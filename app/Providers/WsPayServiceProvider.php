<?php

namespace App\Providers;

use App\Services\WsPay\WsPayService;
use Carbon\Laravel\ServiceProvider;

class WsPayServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(WsPayService::class, function ($app) {
            return new WsPayService();
        });
    }

    public function boot()
    {
        //
    }
}
