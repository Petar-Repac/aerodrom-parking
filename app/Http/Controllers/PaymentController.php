<?php

namespace App\Http\Controllers;

use App\Services\WsPay\WsPayService;
use App\Services\WsPay\Exceptions\WSPayException;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function __construct(
        protected readonly WsPayService $wsPayService,
        protected readonly EmailService $emailService
    ) {
        Log::info('PaymentController initialized');
    }

    /**
     * Handle reservation submission
     * Two flows:
     * 1. Email only (payment-onsite) - sends email and returns success
     * 2. Card payment (payment-online) - initiates WSPay and redirects
     */
    public function createReservation(Request $request)
    {
        Log::info('=== CREATE RESERVATION REQUEST STARTED ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Client IP: ' . $request->ip());
        Log::info('User Agent: ' . $request->userAgent());
        Log::info('Request data (sanitized):', [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'passengers' => $request->input('passengers'),
            'arrivalDate' => $request->input('arrivalDate'),
            'departureDate' => $request->input('departureDate'),
            'paymentMethod' => $request->input('paymentMethod'),
            'totalPrice' => $request->input('totalPrice'),
            'additionalInfo_length' => strlen($request->input('additionalInfo', ''))
        ]);

        try {
            // Validate the incoming request data
            Log::info('Starting validation');
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2|max:100',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|min:6|max:20',
                'passengers' => 'required|integer|min:1',
                'arrivalDate' => 'required|date|after_or_equal:today',
                'departureDate' => 'required|date|after_or_equal:arrivalDate',
                'additionalInfo' => 'nullable|string|max:1000',
                'paymentMethod' => 'required|string|in:payment-onsite,payment-online',
                'totalPrice' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed', [
                    'errors' => $validator->errors()->toArray()
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            Log::info('Validation passed successfully');
            $data = $validator->validated();

            // Generate a unique reservation ID
            $reservationId = $this->generateReservationId();
            Log::info('Generated reservation ID: ' . $reservationId);

            // Calculate number of days
            $arrivalDate = new \DateTime($data['arrivalDate']);
            $departureDate = new \DateTime($data['departureDate']);
            $numOfDays = $arrivalDate->diff($departureDate)->days + 1;
            Log::info('Date calculation completed', [
                'arrival' => $arrivalDate->format('Y-m-d'),
                'departure' => $departureDate->format('Y-m-d'),
                'num_of_days' => $numOfDays
            ]);

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
                'created_at' => now(),
            ];

            Log::info('Reservation data prepared', [
                'reservation_id' => $reservationId,
                'payment_method' => $data['paymentMethod'],
                'total_price' => $data['totalPrice'],
                'num_of_days' => $numOfDays
            ]);

            // Store reservation in session for later use
            session(['pending_reservation' => $reservationData]);
            Log::info('Reservation stored in session', [
                'session_id' => session()->getId(),
                'reservation_id' => $reservationId
            ]);

            // Check payment method
            if ($data['paymentMethod'] === 'payment-onsite') {
                Log::info('Processing ON-SITE payment flow', [
                    'reservation_id' => $reservationId
                ]);

                // Email-only flow - send notification and return success
                $this->sendReservationEmail($reservationData, 'onsite');

                Log::info('=== ON-SITE RESERVATION COMPLETED SUCCESSFULLY ===', [
                    'reservation_id' => $reservationId
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Reservation submitted successfully',
                    'reservation_id' => $reservationId,
                    'payment_method' => 'onsite'
                ]);
            } else {
                Log::info('Processing ONLINE payment flow', [
                    'reservation_id' => $reservationId
                ]);

                // Card payment flow - initiate WSPay payment
                return $this->initiateCardPayment($reservationData);
            }

        } catch (\Exception $e) {
            Log::error('=== RESERVATION SUBMISSION ERROR ===', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
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
    private function initiateCardPayment(array $reservationData)
    {
        Log::info('=== INITIATING CARD PAYMENT ===', [
            'reservation_id' => $reservationData['reservation_id'],
            'amount' => $reservationData['total_price']
        ]);

        try {
            // Get current locale
            $locale = app()->getLocale();
            $routePrefix = $locale === 'sr' ? '' : $locale . '.';

            Log::info('Locale and routes determined', [
                'locale' => $locale,
                'route_prefix' => $routePrefix,
                'return_url' => route($routePrefix . 'payment.success'),
                'return_error_url' => route($routePrefix . 'payment.error'),
                'cancel_url' => route($routePrefix . 'payment.cancel')
            ]);

            $paymentData = [
                'shopping_cart_id' => $reservationData['reservation_id'],
                'total_amount' => $reservationData['total_price'],
                'return_url' => route($routePrefix . 'payment.success'),
                'return_error_url' => route($routePrefix . 'payment.error'),
                'cancel_url' => route($routePrefix . 'payment.cancel'),
                'customer_email' => $reservationData['email'],
                'customer_first_name' => $this->getFirstName($reservationData['name']),
                'customer_last_name' => $this->getLastName($reservationData['name']),
                'customer_phone' => $reservationData['phone'],
                'lang' => $locale === 'sr' ? 'sr' : ($locale === 'ru' ? 'en' : 'en'), // WSPay supports sr and en
            ];

            Log::info('Payment data prepared for WSPay', [
                'shopping_cart_id' => $paymentData['shopping_cart_id'],
                'total_amount' => $paymentData['total_amount'],
                'customer_email' => $paymentData['customer_email'],
                'customer_first_name' => $paymentData['customer_first_name'],
                'customer_last_name' => $paymentData['customer_last_name'],
                'lang' => $paymentData['lang']
            ]);

            Log::info('Calling WSPayService->createPayment()');
            $paymentUrl = $this->wsPayService->createPayment($paymentData);
            Log::info('WSPay payment URL received', [
                'payment_url' => $paymentUrl
            ]);

            Log::info('=== CARD PAYMENT INITIATED SUCCESSFULLY ===', [
                'reservation_id' => $reservationData['reservation_id'],
                'amount' => $reservationData['total_price'],
                'locale' => $locale
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Redirecting to payment',
                'payment_url' => $paymentUrl,
                'payment_method' => 'online'
            ]);

        } catch (WSPayException $e) {
            Log::error('=== WSPAY PAYMENT CREATION FAILED ===', [
                'reservation_id' => $reservationData['reservation_id'],
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
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
        Log::info('=== PAYMENT SUCCESS CALLBACK RECEIVED ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Client IP: ' . $request->ip());
        Log::info('Raw callback data:', $request->all());

        try {
            $callbackData = $request->all();

            Log::info('Processing callback with WSPayService');
            // Verify and process the callback
            $processedData = $this->wsPayService->processCallback($callbackData);
            Log::info('Callback processed successfully', [
                'success' => $processedData['success'] ?? 'unknown',
                'shopping_cart_id' => $processedData['shopping_cart_id'] ?? 'unknown'
            ]);

            if ($processedData['success'] == '1') {
                $reservationId = $processedData['shopping_cart_id'];
                Log::info('Payment marked as successful', [
                    'reservation_id' => $reservationId
                ]);

                // Get reservation from session
                Log::info('Retrieving reservation from session', [
                    'session_id' => session()->getId()
                ]);
                $reservationData = session('pending_reservation');

                if (!$reservationData || $reservationData['reservation_id'] !== $reservationId) {
                    Log::warning('=== RESERVATION DATA MISMATCH OR NOT FOUND ===', [
                        'expected_reservation_id' => $reservationId,
                        'found_reservation_id' => $reservationData['reservation_id'] ?? 'null',
                        'session_has_data' => !is_null($reservationData)
                    ]);
                    return view('payment.error')->with('error', 'Reservation data not found.');
                }

                Log::info('Reservation data retrieved from session successfully');

                // Add payment details
                $reservationData['payment_details'] = [
                    'ws_pay_order_id' => $processedData['ws_pay_order_id'],
                    'approval_code' => $processedData['approval_code'],
                    'stan' => $processedData['stan'],
                    'payment_amount' => $processedData['amount'],
                    'payment_date' => $processedData['datetime'],
                    'credit_card_number' => $processedData['credit_card_number'] ?? null,
                    'payment_status' => 'completed',
                ];
                $reservationData['status'] = 'paid';

                Log::info('Payment details added to reservation', [
                    'ws_pay_order_id' => $processedData['ws_pay_order_id'],
                    'approval_code' => $processedData['approval_code'],
                    'payment_amount' => $processedData['amount']
                ]);

                // Send emails
                Log::info('Sending admin notification email');
                $this->sendReservationEmail($reservationData, 'online_success');

                Log::info('Sending user confirmation email');
                $this->sendUserConfirmationEmail($reservationData);

                // Clear session
                session()->forget('pending_reservation');
                Log::info('Cleared pending reservation from session');

                Log::info('=== PAYMENT COMPLETED SUCCESSFULLY ===', [
                    'reservation_id' => $reservationId,
                    'ws_pay_order_id' => $processedData['ws_pay_order_id']
                ]);

                return view('payment.success', [
                    'reservation' => $reservationData,
                    'payment' => $processedData
                ]);
            } else {
                // Payment was not successful
                Log::warning('=== PAYMENT CALLBACK WITH SUCCESS=0 ===', [
                    'processed_data' => $processedData
                ]);
                return $this->paymentError($request);
            }

        } catch (WSPayException $e) {
            Log::error('=== PAYMENT CALLBACK VERIFICATION FAILED ===', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('payment.error')->with('error', 'Payment verification failed.');
        } catch (\Exception $e) {
            Log::error('=== PAYMENT SUCCESS HANDLER ERROR ===', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('payment.error')->with('error', 'An error occurred processing your payment.');
        }
    }

    /**
     * Handle payment error callback
     */
    public function paymentError(Request $request)
    {
        Log::info('=== PAYMENT ERROR CALLBACK RECEIVED ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Client IP: ' . $request->ip());
        Log::info('Raw callback data:', $request->all());

        try {
            $callbackData = $request->all();

            Log::info('Processing error callback with WSPayService');
            $processedData = $this->wsPayService->processCallback($callbackData);
            Log::info('Error callback processed', $processedData);

            // Get reservation from session
            Log::info('Retrieving reservation from session for error handling');
            $reservationData = session('pending_reservation');

            if ($reservationData) {
                Log::info('Reservation found in session', [
                    'reservation_id' => $reservationData['reservation_id']
                ]);

                $reservationData['status'] = 'payment_failed';
                $reservationData['error_message'] = $processedData['error_message'] ?? 'Payment failed';

                Log::info('Updated reservation status to payment_failed', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'error_message' => $reservationData['error_message']
                ]);

                // Notify admin about failed payment
                Log::info('Sending admin notification about failed payment');
                $this->sendReservationEmail($reservationData, 'online_failed');
            } else {
                Log::warning('No reservation data found in session for error callback');
            }

            Log::warning('=== PAYMENT ERROR PROCESSED ===', $processedData);

            return view('payment.error', [
                'reservation' => $reservationData,
                'error' => $processedData
            ]);

        } catch (WSPayException $e) {
            Log::error('=== PAYMENT ERROR CALLBACK VERIFICATION FAILED ===', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('payment.error')->with('error', 'Payment verification failed.');
        }
    }

    /**
     * Handle payment cancellation
     */
    public function paymentCancel(Request $request)
    {
        Log::info('=== PAYMENT CANCEL CALLBACK RECEIVED ===');
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Client IP: ' . $request->ip());
        Log::info('Raw callback data:', $request->all());

        try {
            $callbackData = $request->all();

            Log::info('Processing cancel callback with WSPayService');
            $processedData = $this->wsPayService->processCallback($callbackData);
            Log::info('Cancel callback processed', $processedData);

            // Get reservation from session
            Log::info('Retrieving reservation from session for cancellation');
            $reservationData = session('pending_reservation');

            if ($reservationData) {
                Log::info('Reservation found in session', [
                    'reservation_id' => $reservationData['reservation_id']
                ]);

                $reservationData['status'] = 'cancelled';
                Log::info('Updated reservation status to cancelled', [
                    'reservation_id' => $reservationData['reservation_id']
                ]);

                // Optionally notify admin
                // $this->sendReservationEmail($reservationData, 'cancelled');
            } else {
                Log::warning('No reservation data found in session for cancel callback');
            }

            Log::info('=== PAYMENT CANCELLED ===', $processedData);

            return view('payment.cancel', [
                'reservation' => $reservationData,
                'data' => $processedData
            ]);

        } catch (WSPayException $e) {
            Log::error('=== PAYMENT CANCEL CALLBACK VERIFICATION FAILED ===', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('payment.cancel')->with('error', 'Payment verification failed.');
        }
    }

    /**
     * Send reservation email to admin using EmailService
     */
    private function sendReservationEmail(array $reservationData, string $type)
    {
        Log::info('=== SENDING ADMIN RESERVATION EMAIL ===', [
            'reservation_id' => $reservationData['reservation_id'],
            'type' => $type
        ]);

        try {
            $to = config('mail.reservation.to', 'petarrepac15@gmail.com');
            Log::info('Email recipient configured', ['to' => $to]);

            $subject = match($type) {
                'onsite' => '[Aeroparking] Nova rezervacija - Plaćanje na licu mesta',
                'online_success' => '[Aeroparking] Nova rezervacija - Online plaćanje uspešno',
                'online_failed' => '[Aeroparking] Neuspelo plaćanje - Zahteva pažnju',
                default => '[Aeroparking] Nova rezervacija'
            };
            Log::info('Email subject determined', ['subject' => $subject]);

            // Build email content
            Log::info('Rendering email template');
            $content = view('emails.reservation-admin', [
                'reservation' => $reservationData,
                'type' => $type
            ])->render();
            Log::info('Email template rendered', ['content_length' => strlen($content)]);

            // Send using EmailService
            Log::info('Calling EmailService->sendEmail()');
            $sent = $this->emailService->sendEmail(
                $to,
                $subject,
                $content,
                'Aeroparking Rezervacije'
            );

            if ($sent) {
                Log::info('=== ADMIN EMAIL SENT SUCCESSFULLY ===', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'type' => $type,
                    'to' => $to
                ]);
            } else {
                Log::warning('=== ADMIN EMAIL FAILED TO SEND ===', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'type' => $type,
                    'to' => $to
                ]);
            }

        } catch (\Exception $e) {
            Log::error('=== ADMIN EMAIL EXCEPTION ===', [
                'reservation_id' => $reservationData['reservation_id'],
                'type' => $type,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Send confirmation email to user using EmailService
     */
    private function sendUserConfirmationEmail(array $reservationData): void
    {
        Log::info('=== SENDING USER CONFIRMATION EMAIL ===', [
            'reservation_id' => $reservationData['reservation_id'],
            'email' => $reservationData['email']
        ]);

        try {
            // Build email content
            Log::info('Rendering user email template');
            $content = view('emails.reservation-user', [
                'reservation' => $reservationData
            ])->render();
            Log::info('User email template rendered', ['content_length' => strlen($content)]);

            // Send using EmailService
            Log::info('Calling EmailService->sendEmail() for user');
            $sent = $this->emailService->sendEmail(
                $reservationData['email'],
                'Potvrda rezervacije - Aeroparking',
                $content,
                $reservationData['name']
            );

            if ($sent) {
                Log::info('=== USER CONFIRMATION EMAIL SENT SUCCESSFULLY ===', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'email' => $reservationData['email']
                ]);
            } else {
                Log::warning('=== USER CONFIRMATION EMAIL FAILED TO SEND ===', [
                    'reservation_id' => $reservationData['reservation_id'],
                    'email' => $reservationData['email']
                ]);
            }

        } catch (\Exception $e) {
            Log::error('=== USER EMAIL EXCEPTION ===', [
                'reservation_id' => $reservationData['reservation_id'],
                'email' => $reservationData['email'],
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            // Don't throw - we don't want to fail the whole process if email fails
        }
    }

    /**
     * Generate unique reservation ID
     */
    private function generateReservationId(): string
    {
        $id = 'AERO-' . strtoupper(uniqid());
        Log::debug('Reservation ID generated', ['id' => $id]);
        return $id;
    }

    /**
     * Extract first name from full name
     */
    private function getFirstName(string $fullName): string
    {
        $parts = explode(' ', trim($fullName));
        $firstName = $parts[0] ?? $fullName;
        Log::debug('Extracted first name', ['full_name' => $fullName, 'first_name' => $firstName]);
        return $firstName;
    }

    /**
     * Extract last name from full name
     */
    private function getLastName(string $fullName): string
    {
        $parts = explode(' ', trim($fullName));
        $lastName = count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : $fullName;
        Log::debug('Extracted last name', ['full_name' => $fullName, 'last_name' => $lastName]);
        return $lastName;
    }
}
