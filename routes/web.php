<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Helpers\RouteHelper;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

$locales = ['sr' => '', 'en' => 'en', 'ru' => 'ru'];

foreach ($locales as $locale => $prefix) {
    $routePrefix = $locale === 'sr' ? '' : $locale . '.';

    Route::group(['prefix' => $prefix, 'middleware' => 'web'], function () use ($locale, $routePrefix) {
        // Home
        Route::get('/', [HomeController::class, 'index'])->name($routePrefix . 'home');

        // About
        Route::get('/' . RouteHelper::getLocalizedPath('about', $locale), function () {
            return view('about');
        })->name($routePrefix . 'about');

        // Contact
        Route::get('/' . RouteHelper::getLocalizedPath('contact', $locale), function () {
            return view('contact');
        })->name($routePrefix . 'contact');

        Route::post('/' . RouteHelper::getLocalizedPath('contact', $locale), [ContactController::class, 'send'])
            ->name($routePrefix . 'contact.send');

        // Pricing
        Route::get('/' . RouteHelper::getLocalizedPath('pricing', $locale), function () {
            return view('pricing');
        })->name($routePrefix . 'pricing');


        Route::get('/' . RouteHelper::getLocalizedPath('payment-success', $locale),
            [PaymentController::class, 'paymentSuccess'])
            ->name($routePrefix . 'payment.success');

        // Payment error callback
        Route::get('/' . RouteHelper::getLocalizedPath('payment-error', $locale), [PaymentController::class, 'paymentError'])
            ->name($routePrefix . 'payment.error');

        // Payment cancel callback
        Route::get('/' . RouteHelper::getLocalizedPath('payment-cancel', $locale), [PaymentController::class, 'paymentCancel'])
            ->name($routePrefix . 'payment.cancel');

        // Terms & Conditions
        Route::get('/' . RouteHelper::getLocalizedPath('terms', $locale), function () {
            return view('terms');
        })->name($routePrefix . 'terms');

    });
}

// Fallback for 404
Route::fallback(function () {
    return response()->view('page-not-found', [], 404);
});
