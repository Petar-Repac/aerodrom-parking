<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Load and cache the specified page.
     *
     * @param string $page The blade view name of the page to load.
     * @return Response
     */
    public function index(): Response
    {
//        $view = view('home')->render();
//        return \response($view);

        // Define a cache key based on the page name
        $cacheKey = 'home_page_cache';

//        // Check if the page is cached
//        if (Cache::has($cacheKey)) {
//            Log::info('Page loaded from cache: home');
//            return response(Cache::get($cacheKey));
//        }

        Log::info('Page not cached, rendering: home');

        // Render the view, handle cases where the view might not exist
        try {
            $view = view('home')->render();
        } catch (\InvalidArgumentException $e) {
            Log::error('Failed to render view: ' . $e->getMessage());
            // Optionally, return a default view or error page
            return response('Page not found', 404);
        }

        // Cache the rendered HTML for 5 minutes
        Cache::put($cacheKey, $view, now()->addMinutes(5));

        // Return the view
        return response($view);
    }
}
