<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class LocalizationHelper
{
    public static function getLocalizedUrl($locale, $routeName = null, $parameters = [])
    {
        $currentLocale = App::getLocale();

        if (!$routeName) {
            $routeName = Route::currentRouteName();

            // If no route name (like on 404 pages), default to home
            if (!$routeName) {
                $routeName = 'home';
            } else {
                // Remove locale prefix from route name
                $routeName = preg_replace('/^(en|ru)\./', '', $routeName);
            }
        }

        if ($locale === 'sr') {
            return route($routeName, $parameters);
        } else {
            return route($locale . '.' . $routeName, $parameters);
        }
    }

    public static function getAlternateUrls()
    {
        $locales = ['sr', 'en', 'ru'];
        $currentRoute = Route::currentRouteName();

        // If no route (404 page), use home route for alternates
        if (!$currentRoute) {
            $baseRoute = 'home';
        } else {
            // Remove locale prefix to get base route name
            $baseRoute = preg_replace('/^(en|ru)\./', '', $currentRoute);
        }

        $urls = [];

        foreach ($locales as $locale) {
            if ($locale === 'sr') {
                $urls[$locale] = route($baseRoute);
            } else {
                $urls[$locale] = route($locale . '.' . $baseRoute);
            }
        }

        return $urls;
    }
}
