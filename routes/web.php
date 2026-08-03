<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Helpers\RouteHelper;
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

        // Terms & Conditions
        Route::get('/' . RouteHelper::getLocalizedPath('terms', $locale), function () {
            return view('terms');
        })->name($routePrefix . 'terms');

    });
}

// Admin dashboard (not locale-prefixed - internal tool, single language)
Route::prefix('admin')->name('admin.')->middleware('web')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])
            ->middleware('throttle:6,1')
            ->name('login.attempt');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });
});

// Fallback for 404
Route::fallback(function () {
    return response()->view('page-not-found', [], 404);
});
