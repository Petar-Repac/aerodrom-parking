<?php

namespace App\Http\Controllers;

use App\Services\GraphQLService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{

    /**
     * @param GraphQLService $graphQLService
     */
    public function __construct(protected readonly GraphQLService $graphQLService) {}

    /**
     * @return JsonResponse
     */
    public function index(): Response
    {
        $articles = $this->graphQLService->fetchNewsArticles();
        $view = view('blog', ['articles' => $articles['data']['NewsArticles']])->render();
        return \response($view);

        // Define a cache key based on the page name
        $cacheKey = 'blog_page_cache';

        // Check if the page is cached
        if (Cache::has($cacheKey)) {
            Log::info('Page loaded from cache: home');
            return response(Cache::get($cacheKey));
        }

        Log::info('Page not cached, rendering: home');

        // Render the view, handle cases where the view might not exist
        try {

            $articles = $this->graphQLService->fetchNewsArticles();
            $view = view('blog', ['articles' => $articles])->render();
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

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $article = $this->graphQLService->fetchNewsArticleById($id);
        if (empty($article)) {
            return response()->json(['message' => 'Article not found'], 404);
        }
        return response()->json($article);
    }
}
