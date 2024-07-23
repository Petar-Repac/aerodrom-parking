<?php
declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class GraphQLService
{
    protected $client;
    protected $url = 'https://directus-cms.aeroparking.rs/graphql';

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return array
     */
    public function fetchNewsArticles(): array
    {
        try {
            return Cache::remember('news_articles', 60*60, function () {  // Cache for 1 hour
                $query = [
                    'query' => 'query GetItems {
                    NewsArticles {
                        id,
                        Title,
                        Lead,
                        Thumbnail {
                            id
                        }
                    }
                }'
                ];

                $response = $this->client->post($this->url, [
                    'json' => $query,
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('DIRECTUS_API_TOKEN'),
                        'Content-Type' => 'application/json',
                    ]
                ]);

                return json_decode($response->getBody()->getContents(), true);
            });
        }
       catch (\Exception $e) {
            return ['error' => $e->getMessage()];
       }
    }

    /**
     * @param string $id News Article Id
     * @return array
     */
    public function fetchNewsArticleById(string $id): array
    {

        try {
            return Cache::remember('news_article_' . $id, 0, function () use ($id) {  // Cache for 1 hour
                $query = [
                    'query' => "query GetSingleArticle {
                NewsArticles(filter: {id: {_eq: \"$id\"}}) {
                    id,
                    Title,
                    Lead,
                    Content,
                    Thumbnail {
                        id,
                        title,
                        width,
                        height
                    }
                }
            }"];

                $response = $this->client->post($this->url, [
                    'json' => $query,
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('DIRECTUS_API_TOKEN'),
                        'Content-Type' => 'application/json',
                    ]
                ]);

                return json_decode($response->getBody()->getContents(), true);
            });
        }
        catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
