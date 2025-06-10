<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Your reservation routes
Route::post('/reservations', [ReservationController::class, 'store']);

// Handle CORS preflight
Route::options('/reservations', function () {
    return response()->json([], 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'POST, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
});

// Optional: Add rate limiting to prevent spam
Route::middleware(['throttle:5,1'])->group(function () {
    // This limits to 5 requests per minute per IP
    Route::post('/reservations', [ReservationController::class, 'store']);
});

// If you want to group related routes:
Route::prefix('aero-parking')->group(function () {
    Route::post('/reservations', [ReservationController::class, 'store']);
    // Add more routes as needed
});
