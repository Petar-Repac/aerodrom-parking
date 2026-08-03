<?php

namespace App\Providers;

use App\Services\ParkingPriceService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(
            ['partials.data.prices', 'partials.page-sections.pricing'],
            function ($view) {
                $priceData = app(ParkingPriceService::class)->getPrices();

                $view->with([
                    'prices' => $priceData['prices'],
                    'pricesList' => collect($priceData['prices'])
                        ->map(fn ($price, $days) => ['days' => $days, 'price' => $price])
                        ->values()
                        ->all(),
                    'extraDayRate' => $priceData['extra_day_rate'],
                ]);
            },
        );
    }
}
