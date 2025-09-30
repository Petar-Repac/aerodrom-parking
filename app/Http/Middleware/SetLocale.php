<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
class SetLocale
{
    protected $locales = ['sr', 'en', 'ru'];
    protected $defaultLocale = 'sr';

    public function handle(Request $request, Closure $next)
    {
        $locale = $request->segment(1);

        // Check if first segment is a valid locale
        if (in_array($locale, $this->locales)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // Default to Serbian
            App::setLocale($this->defaultLocale);
            Session::put('locale', $this->defaultLocale);
        }

        return $next($request);
    }
}
