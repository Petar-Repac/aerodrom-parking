<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            SetLocale::class,
        ]);

        // Deliberately not using $middleware->statefulApi() here - that
        // applies Sanctum's stateful (session/CSRF) pipeline to the
        // entire api middleware group, which would also wrap the public,
        // unauthenticated /api/reservations endpoint in CSRF checks it was
        // never built to satisfy. Instead, EnsureFrontendRequestsAreStateful
        // is applied directly to just the admin route group in routes/api.php.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
