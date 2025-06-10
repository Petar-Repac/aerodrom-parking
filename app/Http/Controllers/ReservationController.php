<?php

namespace App\Http\Controllers;

use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    protected EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
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

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'passengers' => 'required|integer|min:1|max:20',
            'arrivalDate' => 'required|string|max:100',
            'departureDate' => 'required|string|max:100',
            'additionalInfo' => 'nullable|string|max:1000',
        ]);

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
                'additionalInfo' => $this->sanitize($request->input('additionalInfo', '')),
            ];

            // Send the reservation email
            $emailSent = $this->emailService->sendReservationEmail($reservationData);

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
}
