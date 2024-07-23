<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\GraphQLService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    /**
     * @param GraphQLService $graphQLService
     */
    public function __construct(protected readonly GraphQLService $graphQLService) {}

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $articles = $this->graphQLService->fetchNewsArticles();
        return response()->json($articles);
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
