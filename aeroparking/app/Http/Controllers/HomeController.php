<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * @return ResponseFactory|Application|Response
     */
   public function index(): ResponseFactory|Application|Response
   {
       // Define a cache key
       $cacheKey = 'home_page';

       // Check if the page is cached
       if (Cache::has($cacheKey)) {
           // Return the cached HTML
           Log::info('CACHED');
           return response(Cache::get($cacheKey));
       }
       Log::info('NOT CACHED');

       // Render the view
       $view = view('home')->render();

       // Cache the rendered HTML
       Cache::put($cacheKey, $view, 1 * 60); // Cache for 1 minute

       // Return the view
       return response($view);
   }
}
