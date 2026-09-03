<?php

namespace App\Helpers;

class RouteHelper
{
    public static function localizedRoute($name, $parameters = [], $absolute = true)
    {
        $locale = app()->getLocale();

        // Handle cases where route might not exist (like 404 pages)
        try {
            if ($locale === 'sr') {
                return route($name, $parameters, $absolute);
            }

            return route($locale . '.' . $name, $parameters, $absolute);
        } catch (\Exception $e) {
            // Fallback to home if route doesn't exist
            if ($locale === 'sr') {
                return route('home', [], $absolute);
            }
            return route($locale . '.home', [], $absolute);
        }
    }

    public static function getLocalizedPath($routeKey, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        $paths = [
            'about' => [
                'sr' => 'o-nama',
                'en' => 'about',
                'ru' => 'o-nas',
            ],
            'contact' => [
                'sr' => 'kontakt',
                'en' => 'contact',
                'ru' => 'kontakt',
            ],
            'pricing' => [
                'sr' => 'cenovnik',
                'en' => 'pricing',
                'ru' => 'ceny',
            ],
            'payment-success' => [
                'sr' => 'placanje/uspesno',
                'en' => 'payment/success',
                'ru' => 'oplata/uspeshno',
            ],
            'payment-error' => [
                'sr' => 'placanje/greska',
                'en' => 'payment/error',
                'ru' => 'oplata/oshibka',
            ],
            'payment-cancel' => [
                'sr' => 'placanje/otkazano',
                'en' => 'payment/cancel',
                'ru' => 'oplata/otmeneno',
            ],
            'terms' => [
                'sr' => 'uslovi-koriscenja',
                'en' => 'terms-and-conditions',
                'ru' => 'usloviya-ispolzovaniya',
            ],
            'privacy' => [
                'sr' => 'politika-privatnosti',
                'en' => 'privacy-policy',
                'ru' => 'politika-konfidencialnosti',
            ],
        ];

        return $paths[$routeKey][$locale] ?? $paths[$routeKey]['sr'];
    }
}
