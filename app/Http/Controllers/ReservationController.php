<?php

namespace App\Http\Controllers;

use App\Services\EmailService;
use App\Services\ParkingPriceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    protected EmailService $emailService;
    protected ParkingPriceService $priceService;

    public function __construct(EmailService $emailService, ParkingPriceService $priceService)
    {
        $this->emailService = $emailService;
        $this->priceService = $priceService;
    }

    /**
     * Handle reservation submission
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Add CORS headers
        if ($request->getMethod() === 'OPTIONS') {
            return response()->json([], 200)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        // /api/reservations runs under the 'api' middleware group, which
        // doesn't go through SetLocale, so app()->getLocale() would
        // otherwise fall back to APP_LOCALE regardless of the page the
        // customer actually submitted the reservation from. This has to
        // happen before the customer confirmation email is rendered below.
        $locale = $request->input('locale');
        if (in_array($locale, ['sr', 'en', 'ru'], true)) {
            app()->setLocale($locale);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'passengers' => 'required|integer|min:1|max:20',
            'arrivalDate' => 'required|date_format:Y-m-d',
            'departureDate' => 'required|date_format:Y-m-d',
            'arrivalTime' => 'required|date_format:H:i',
            'departureTime' => 'required|date_format:H:i',
            'additionalInfo' => 'nullable|string|max:1000',
        ]);

        // Guard against same-day (or any) reservations where the departure
        // date+time isn't actually after the arrival date+time - e.g.
        // arriving at 16:00 and "departing" at 01:00 the same day.
        $validator->after(function ($validator) use ($request) {
            if ($validator->errors()->hasAny(['arrivalDate', 'departureDate', 'arrivalTime', 'departureTime'])) {
                return;
            }

            $arrival = Carbon::createFromFormat(
                'Y-m-d H:i',
                $request->input('arrivalDate') . ' ' . $request->input('arrivalTime')
            );
            $departure = Carbon::createFromFormat(
                'Y-m-d H:i',
                $request->input('departureDate') . ' ' . $request->input('departureTime')
            );

            if ($departure->lessThanOrEqualTo($arrival)) {
                $validator->errors()->add('departureDate', 'Departure date and time must be after arrival date and time.');
            }
        });

        if ($validator->fails()) {
            Log::warning('Reservation validation failed', [
                'errors' => $validator->errors()->toArray(),
                'request_data' => $request->except(['password', 'token'])
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        try {
            // Sanitize input data
            $reservationData = [
                'name' => $this->sanitize($request->input('name')),
                'email' => $this->sanitize($request->input('email')),
                'phone' => $this->sanitize($request->input('phone')),
                'passengers' => $this->sanitize($request->input('passengers')),
                'arrivalDate' => $this->sanitize($request->input('arrivalDate')),
                'departureDate' => $this->sanitize($request->input('departureDate')),
                'arrivalTime' => $this->sanitize($request->input('arrivalTime')),
                'departureTime' => $this->sanitize($request->input('departureTime')),
                'additionalInfo' => $this->sanitize($request->input('additionalInfo', '')),
            ];

            // Send the staff notification email (unchanged)
            $emailSent = $this->emailService->sendReservationEmail($reservationData);

            // Send the customer-facing confirmation email. Built from raw
            // (trimmed, not htmlspecialchars'd) input rather than
            // $reservationData above, since Blade's {{ }} already escapes
            // for HTML output - running already-escaped values through it
            // too would double-escape (e.g. an apostrophe in a name would
            // render as "&#039;" instead of "'").
            $reservationId = $this->generateReservationId();
            $arrivalDate = Carbon::createFromFormat('Y-m-d', trim((string) $request->input('arrivalDate')));
            $departureDate = Carbon::createFromFormat('Y-m-d', trim((string) $request->input('departureDate')));
            $numOfDays = $arrivalDate->diffInDays($departureDate) + 1;

            $confirmationData = [
                'reservation_id' => $reservationId,
                'name' => trim((string) $request->input('name')),
                'email' => trim((string) $request->input('email')),
                'phone' => trim((string) $request->input('phone')),
                'passengers' => trim((string) $request->input('passengers')),
                'arrival_date' => trim((string) $request->input('arrivalDate')),
                'arrival_time' => trim((string) $request->input('arrivalTime')),
                'departure_date' => trim((string) $request->input('departureDate')),
                'departure_time' => trim((string) $request->input('departureTime')),
                'num_of_days' => $numOfDays,
                'amount' => $this->calculateAmount($numOfDays),
            ];

            try {
                $confirmationContent = view('email.reservation-confirmation', [
                    'reservation' => $confirmationData,
                ])->render();

                $confirmationSent = $this->emailService->sendEmail(
                    $confirmationData['email'],
                    __('messages.reservation_confirmation.subject', ['id' => $reservationId]),
                    $confirmationContent,
                    $confirmationData['name']
                );

                if ($confirmationSent) {
                    Log::info('Customer confirmation email sent', [
                        'reservation_id' => $reservationId,
                        'customer_email' => $confirmationData['email']
                    ]);
                } else {
                    Log::warning('Customer confirmation email failed to send', [
                        'reservation_id' => $reservationId,
                        'customer_email' => $confirmationData['email']
                    ]);
                }
            } catch (\Exception $e) {
                // Don't fail the whole request if the confirmation email
                // errors out - the staff notification above is what the
                // response's success status is actually reporting on.
                Log::error('Failed to send customer confirmation email: ' . $e->getMessage(), [
                    'reservation_id' => $reservationId
                ]);
            }

            if ($emailSent) {
                Log::info('Reservation email sent successfully', [
                    'customer_name' => $reservationData['name'],
                    'customer_email' => $reservationData['email']
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Reservation email sent successfully'
                ], 200)
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                    ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
            } else {
                Log::error('Failed to send reservation email', [
                    'customer_name' => $reservationData['name'],
                    'customer_email' => $reservationData['email']
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send reservation email'
                ], 500)
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                    ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
            }

        } catch (\Exception $e) {
            Log::error('Reservation processing error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your reservation'
            ], 500)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }
    }

    /**
     * Sanitize input data
     *
     * @param mixed $data
     * @return string
     */
    private function sanitize($data): string
    {
        if (is_null($data)) {
            return '';
        }

        return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Mirrors reservation.js's client-side price lookup (same admin-
     * editable price table via ParkingPriceService) so the confirmation
     * email can show the amount the customer already saw on the form.
     *
     * @return int|null Null only if the price table has a gap for this
     *                   day count (e.g. mid-range days not yet seeded).
     */
    private function calculateAmount(int $numOfDays): ?int
    {
        $data = $this->priceService->getPrices();

        if ($numOfDays > ParkingPriceService::MAX_DAYS) {
            return $numOfDays * $data['extra_day_rate'];
        }

        return $data['prices'][$numOfDays] ?? null;
    }

    /**
     * Generate a reservation ID for display in emails. Not persisted -
     * this branch has no reservations table - just needs to be unique
     * enough to show in the confirmation and staff notification.
     *
     * @return string
     */
    private function generateReservationId(): string
    {
        return 'AERO-' . strtoupper(uniqid());
    }
}
