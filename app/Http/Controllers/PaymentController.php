<?php

namespace App\Http\Controllers;

use App\Services\WsPay\WsPayService;
use App\Services\WsPay\Exceptions\WSPayException;
use App\Services\EmailService;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function __construct(
        protected readonly WsPayService $wsPayService,
        protected readonly EmailService $emailService
    ) {}

    /**
     * Handle reservation submission
     * Two flows:
     * 1. Email only (payment-onsite) - sends email and returns success
     * 2. Card payment (payment-online) - initiates WSPay and redirects
     */
    public function createReservation(Request $request)
    {
        try {
            // /api/reservations runs under the 'api' middleware group, which
            // doesn't go through SetLocale, so app()->getLocale() would
            // otherwise fall back to APP_LOCALE regardless of the page the
            // customer actually submitted the reservation from. This has to
            // happen before validation runs so that validation error
            // messages below are translated too, not just the success path.
            $locale = $request->input('locale');
            if (in_array($locale, ['sr', 'en', 'ru'], true)) {
                app()->setLocale($locale);
            }

            // The parking is a physical service in Serbia, so "today" for
            // booking purposes always means today in Serbia - not the app's
            // UTC storage timezone (config('app.timezone')) and not the
            // customer's own timezone (which the server has no way to know).
            $belgradeToday = now('Europe/Belgrade')->toDateString();

            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2|max:100',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|min:6|max:20',
                'passengers' => 'required|integer|min:1',
                'arrivalDate' => 'required|date|after_or_equal:' . $belgradeToday,
                'departureDate' => 'required|date|after_or_equal:arrivalDate',
                'additionalInfo' => 'nullable|string|max:1000',
                'paymentMethod' => 'required|string|in:payment-onsite,payment-online',
                'totalPrice' => 'required|numeric|min:0',
                'locale' => 'nullable|string|in:sr,en,ru',
            ], [
                'arrivalDate.after_or_equal' => __('js.arrival_date_past'),
                'departureDate.after_or_equal' => __('js.arrival_before_departure'),
                'arrivalDate.required' => __('js.enter_arrival_date'),
                'departureDate.required' => __('js.enter_departure_date'),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Generate a unique reservation ID
            $reservationId = $this->generateReservationId();

            // Calculate number of days
            $arrivalDate = new \DateTime($data['arrivalDate']);
            $departureDate = new \DateTime($data['departureDate']);
            $numOfDays = $arrivalDate->diff($departureDate)->days + 1;

            // Prepare reservation data
            $reservationData = [
                'reservation_id' => $reservationId,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'passengers' => $data['passengers'],
                'arrival_date' => $data['arrivalDate'],
                'departure_date' => $data['departureDate'],
                'num_of_days' => $numOfDays,
                'total_price' => $data['totalPrice'],
                'additional_info' => $data['additionalInfo'] ?? '',
                'payment_method' => $data['paymentMethod'],
                'status' => 'pending',
            ];

            // Save reservation to database
            $reservation = Reservation::create($reservationData);

            Log::info('Reservation saved to database', [
                'reservation_id' => $reservationId,
                'id' => $reservation->id
            ]);
            // Check payment method
            if ($data['paymentMethod'] === 'payment-onsite') {
                // Email-only flow - send notification and return success
                $this->sendReservationEmail($reservation->toArray(), 'onsite');

                return response()->json([
                    'status' => 'success',
                    'message' => 'Reservation submitted successfully',
                    'reservation_id' => $reservationId,
                    'payment_method' => 'onsite'
                ]);
            } else {
                // Card payment flow - initiate WSPay payment
                return $this->initiateCardPayment($reservation);
            }

        } catch (\Exception $e) {
            Log::error('Reservation submission error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'There was an error processing your reservation. Please try again or contact us directly.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Initiate card payment via WSPay
     */
    private function initiateCardPayment(Reservation $reservation)
    {
        try {
            $paymentData = [
                'shopping_cart_id' => $reservation->reservation_id,
                'total_amount' => $reservation->total_price,
                'return_url' => \App\Helpers\RouteHelper::localizedRoute('payment.success'),
                'return_error_url' => \App\Helpers\RouteHelper::localizedRoute('payment.error'),
                'cancel_url' => \App\Helpers\RouteHelper::localizedRoute('payment.cancel'),
                'customer_email' => $reservation->email,
                'customer_first_name' => $this->getFirstName($reservation->name),
                'customer_last_name' => $this->getLastName($reservation->name),
                'customer_phone' => $reservation->phone,
                'lang' => app()->getLocale() === 'sr' ? 'sr' : (app()->getLocale() === 'ru' ? 'en' : 'en'), // WSPay supports sr and en
            ];

            $paymentUrl = $this->wsPayService->createPayment($paymentData);

            Log::info('WSPay payment initiated', [
                'reservation_id' => $reservation->reservation_id,
                'amount' => $reservation->total_price,
                'locale' => app()->getLocale()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Redirecting to payment',
                'payment_url' => $paymentUrl,
                'payment_method' => 'online'
            ]);

        } catch (WSPayException $e) {
            Log::error('WSPay payment creation failed: ' . $e->getMessage());

            // Update reservation status
            $reservation->update([
                'status' => 'payment_failed',
                'error_message' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment initialization failed. Please try again or choose on-site payment.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Handle successful payment callback
     */
    public function paymentSuccess(Request $request)
    {
        try {
            $callbackData = $request->all();

            Log::info('Payment success callback received', [
                'shopping_cart_id' => $callbackData['ShoppingCartID'] ?? 'N/A'
            ]);

            // Verify and process the callback
            $processedData = $this->wsPayService->processCallback($callbackData);

            if ($processedData['success'] == '1') {
                $reservationId = $processedData['shopping_cart_id'];

                // Get reservation from database
                $reservation = Reservation::where('reservation_id', $reservationId)->first();

                if (!$reservation) {
                    Log::error('Reservation not found in database', [
                        'reservation_id' => $reservationId
                    ]);
                    return view('payment.error')->with('error', 'Reservation not found.');
                }

                // Update reservation with payment details
                $reservation->update([
                    'status' => 'paid',
                    'ws_pay_order_id' => $processedData['ws_pay_order_id'],
                    'approval_code' => $processedData['approval_code'],
                    'stan' => $processedData['stan'],
                    'payment_amount' => $processedData['amount'],
                    'payment_date' => $processedData['datetime'] ? now() : null,
                    'credit_card_number' => $processedData['credit_card_number'] ?? null,
                    'payment_status' => 'completed',
                ]);

                // Send emails
                $this->sendReservationEmail($reservation->toArray(), 'online_success');
                $this->sendUserConfirmationEmail($reservation->toArray());

                Log::info('Payment successful', [
                    'reservation_id' => $reservationId,
                    'ws_pay_order_id' => $processedData['ws_pay_order_id']
                ]);

                return view('payment.success', [
                    'reservation' => $reservation->toArray(),
                    'payment' => $processedData
                ]);
            } else {
                // Payment was not successful
                Log::warning('Payment callback success=0', $processedData);
                return $this->paymentError($request);
            }

        } catch (WSPayException $e) {
            Log::error('Payment callback verification failed: ' . $e->getMessage());
            return view('payment.error')->with('error', 'Payment verification failed.');
        } catch (\Exception $e) {
            Log::error('Payment success handler error: ' . $e->getMessage());
            return view('payment.error')->with('error', 'An error occurred processing your payment.');
        }
    }

    /**
     * Handle payment error callback
     */
    public function paymentError(Request $request)
    {
        try {
            $callbackData = $request->all();
            $processedData = $this->wsPayService->processCallback($callbackData);

            $reservationId = $processedData['shopping_cart_id'] ?? null;

            if ($reservationId) {
                // Get reservation from database
                $reservation = Reservation::where('reservation_id', $reservationId)->first();

                if ($reservation) {
                    // Update reservation status
                    $reservation->update([
                        'status' => 'payment_failed',
                        'error_message' => $processedData['error_message'] ?? 'Payment failed'
                    ]);

                    // Notify admin about failed payment
                    $this->sendReservationEmail($reservation->toArray(), 'online_failed');

                    // Notify user about failed payment
                    $this->sendUserFailedPaymentEmail($reservation->toArray());

                    Log::warning('Payment error', [
                        'reservation_id' => $reservationId,
                        'error' => $processedData['error_message'] ?? 'Unknown'
                    ]);

                    return view('payment.error', [
                        'reservation' => $reservation->toArray(),
                        'error' => $processedData
                    ]);
                }
            }

            Log::warning('Payment error - reservation not found', $processedData);

            return view('payment.error', [
                'reservation' => null,
                'error' => $processedData
            ]);

        } catch (WSPayException $e) {
            Log::error('Payment error callback verification failed: ' . $e->getMessage());
            return view('payment.error')->with('error', 'Payment verification failed.');
        }
    }

    /**
     * Handle payment cancellation
     */
    public function paymentCancel(Request $request)
    {
        try {
            $callbackData = $request->all();
            $processedData = $this->wsPayService->processCallback($callbackData);

            $reservationId = $processedData['shopping_cart_id'] ?? null;

            if ($reservationId) {
                // Get reservation from database
                $reservation = Reservation::where('reservation_id', $reservationId)->first();

                if ($reservation) {
                    // Update reservation status
                    $reservation->update([
                        'status' => 'cancelled'
                    ]);

                    Log::info('Payment cancelled', [
                        'reservation_id' => $reservationId
                    ]);

                    return view('payment.cancel', [
                        'reservation' => $reservation->toArray(),
                        'data' => $processedData
                    ]);
                }
            }

            Log::info('Payment cancelled - reservation not found', $processedData);

            return view('payment.cancel', [
                'reservation' => null,
                'data' => $processedData
            ]);

        } catch (WSPayException $e) {
            Log::error('Payment cancel callback verification failed: ' . $e->getMessage());
            return view('payment.cancel')->with('error', 'Payment verification failed.');
        }
    }

    /**
     * Send reservation email to admin using EmailService
     */
    private function sendReservationEmail(array $reservationData, string $type)
    {
        try {
            $to = config('mail.reservation.to', 'rezervacije@aeroparking.rs');

            $subject = match($type) {
                'onsite' => '[Aeroparking] Nova rezervacija - Plaćanje na licu mesta',
                'online_success' => '[Aeroparking] Nova rezervacija - Online plaćanje uspešno',
                'online_failed' => '[Aeroparking] Neuspelo plaćanje - Zahteva pažnju',
                default => '[Aeroparking] Nova rezervacija'
            };

            // Build email content
            $content = view('email.reservation-admin', [
                'reservation' => $reservationData,
                'type' => $type
            ])->render();

            // Send using EmailService
            $sent = $this->emailService->sendEmail(
                $to,
                $subject,
                $content,
                'Aeroparking Rezervacije'
            );

            if ($sent) {
                Log::info('Admin notification email sent', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'type' => $type
                ]);
            } else {
                Log::warning('Admin notification email failed to send', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'type' => $type
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Failed to send admin notification email: ' . $e->getMessage());
        }
    }

    /**
     * Send confirmation email to user using EmailService
     */
    private function sendUserConfirmationEmail(array $reservationData)
    {
        try {
            // Build email content
            $content = view('email.reservation-user', [
                'reservation' => $reservationData
            ])->render();

            // Send using EmailService
            $sent = $this->emailService->sendEmail(
                $reservationData['email'],
                __('messages.payment.subject_confirmation'),
                $content,
                $reservationData['name']
            );

            if ($sent) {
                Log::info('User confirmation email sent', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'email' => $reservationData['email']
                ]);
            } else {
                Log::warning('User confirmation email failed to send', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'email' => $reservationData['email']
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Failed to send user confirmation email: ' . $e->getMessage());
            // Don't throw - we don't want to fail the whole process if email fails
        }
    }

    /**
     * Send failed payment notification email to user
     */
    private function sendUserFailedPaymentEmail(array $reservationData)
    {
        try {
            $content = view('email.reservation-failed-user', [
                'reservation' => $reservationData
            ])->render();

            $sent = $this->emailService->sendEmail(
                $reservationData['email'],
                __('messages.payment.subject_failed'),
                $content,
                $reservationData['name']
            );

            if ($sent) {
                Log::info('User failed payment email sent', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'email' => $reservationData['email']
                ]);
            } else {
                Log::warning('User failed payment email failed to send', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'email' => $reservationData['email']
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send user failed payment email: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique reservation ID
     */
    private function generateReservationId(): string
    {
        return 'AERO-' . strtoupper(uniqid());
    }

    /**
     * Extract first name from full name
     */
    private function getFirstName(string $fullName): string
    {
        $parts = explode(' ', trim($fullName));
        return $parts[0] ?? $fullName;
    }

    /**
     * Extract last name from full name
     */
    private function getLastName(string $fullName): string
    {
        $parts = explode(' ', trim($fullName));
        return count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : $fullName;
    }
}
