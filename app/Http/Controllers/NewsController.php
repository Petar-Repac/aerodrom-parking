<?php

namespace App\Http\Controllers;

use App\Services\DirectusService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{

    private const PAGE_SIZE = 12;

    /**
     * @param DirectusService $directusService
     */
    public function __construct(protected readonly DirectusService $directusService) {}

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        // Get page parameter from the request, default to 1
        $page = (int) $request->query('page', 1);
        // Get tag parameter from request, if any
        $tag = $request->query('tag');

        // Ensure page is at least 1
        $page = max(1, $page);

        Log::info("Page not cached, rendering: news page {$page}" . ($tag ? " with tag {$tag}" : ""));

        // Render the view, handle cases where the view might not exist
        try {
            // Fetch articles based on whether a tag filter is applied
            $result = $tag
                ? $this->directusService->fetchNewsByTag($tag, $page, self::PAGE_SIZE)
                : $this->directusService->fetchNewsArticles($page, self::PAGE_SIZE);

            $articles = $result['articles'];
            $pagination = $result['pagination'];

            $view = view(
                'pages.news',
                [
                    'articles' => $articles,
                    'pagination' => $pagination,
                    'currentPage' => $page,
                    'activeTag' => $tag
                ]
            )->render();
        }
        catch (\InvalidArgumentException|\Exception $e) {
            Log::error('Failed to render view: ' . $e->getMessage());
            // Optionally, return a default view or error page
            return response($e->getMessage(), 404);
        }

        // Return the view
        return response($view);
    }

    /**
     * Filter news by tag
     *
     * @param Request $request
     * @param string $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function filterByTag(Request $request, string $tag): \Illuminate\Http\RedirectResponse
    {
        // Redirect to the index route with tag parameter
        return redirect()->route('news', ['tag' => $tag, 'page' => $request->query('page', 1)]);
    }



    /**
     * @param string $slug
     * @return Response
     */
    public function single(string $slug): Response
    {
        // Render the view, handle cases where the view might not exist
        try {
            $article = $this->directusService->fetchNewsArticleBySlug($slug);
            if(!isset($article)){
                return response()->view('pages.page-not-found', [], 404);
            }
            $view = view('pages.news-single', ['article' => $article])->render();
        } catch (\InvalidArgumentException $e) {
            Log::error('Failed to render view: ' . $e->getMessage());
            // Optionally, return a default view or error page
            return response()->view('pages.page-not-found', [], 404);
        }
        // Return the view
        return response($view);
    }
}
