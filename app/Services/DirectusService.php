<?php
declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DirectusService
{
    /**
     * Guzzle HTTP client
     *
     * @var Client
     */
    protected $client;

    /**
     * Directus GraphQL endpoint
     *
     * @var string
     */
    protected $url = 'https://cms.aeroparking.rs/graphql';

    /**
     * Default cache duration in minutes
     *
     * @var int
     */
    protected $cacheDuration = 60; // 1 hour

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->url = env('DIRECTUS_URL');
        // Allow cache duration to be configured via .env
        if (env('DIRECTUS_CACHE_DURATION_MINS')) {
            $this->cacheDuration = (int)env('DIRECTUS_CACHE_DURATION_MINS');
        }
    }

    /**
     * Get cache key prefix for a specific collection
     *
     * @param string $collection Collection name
     * @return string
     */
    protected function getCachePrefix(string $collection): string
    {
        return strtolower($collection) . '_';
    }

    /**
     * Execute a GraphQL query with caching
     *
     * @param array $query GraphQL query
     * @param string $cacheKey Cache key
     * @param int|null $customDuration Optional custom cache duration in minutes
     * @return array
     */
    protected function executeQuery(array $query, string $cacheKey, ?int $customDuration = null): array
    {
        $duration = $customDuration ?? $this->cacheDuration;
        Log::info('URL USED TO SEND REQUEST: ' . $this->url . ' with token ' . env('DIRECTUS_API_TOKEN'));

        return Cache::remember($cacheKey, now()->addMinutes($duration), function () use ($query) {
            try {
                $response = $this->client->post($this->url, [
                    'json' => $query,
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('DIRECTUS_API_TOKEN'),
                        'Content-Type' => 'application/json'
                    ]
                ]);

                return json_decode($response->getBody()->getContents(), true);
            } catch (\Exception $e) {
                Log::error('GraphQL query error: ' . $e->getMessage(), [
                    'query' => $query,
                    'trace' => $e->getTraceAsString()
                ]);

                return ['data' => [], 'errors' => [$e->getMessage()]];
            }
        });
    }

    /**
     * Fetch news articles with pagination
     *
     * @param int $page Page number (starting from 1)
     * @param int $pageSize Number of items per page
     * @return array
     */
    public function fetchNewsArticles(int $page = 1, int $pageSize = 12): array
    {
        $cacheKey = $this->getCachePrefix('Articles') . "page{$page}_size{$pageSize}";

        // Calculate offset based on page number
        $offset = ($page - 1) * $pageSize;

        // Query with correct aggregation structure
        $query = [
            'query' => 'query GetPaginatedArticles($limit: Int!, $offset: Int!) {
                Articles (
                    filter: {status: {_eq: "published"}},
                    limit: $limit,
                    offset: $offset,
                    sort: "-date_created"
                ) {
                    id,
                    date_created,
                    title,
                    status,
                    lead,
                    tags,
                    slug,
                    thumbnail {
                        id
                    }
                }
                Articles_aggregated(filter: {status: {_eq: "published"}}) {
                    count {
                        id
                    }
                }
            }',
            'variables' => [
                'limit' => $pageSize,
                'offset' => $offset
            ]
        ];

        $json = $this->executeQuery($query, $cacheKey);

        if (isset($json['errors'])) {
            Log::error('GraphQL error in fetchNewsArticles: ' . json_encode($json['errors']));
            return $this->getEmptyPaginationResult($page, $pageSize);
        }

        // Extract the count from the correct location in the response
        $totalCount = $this->extractTotalCount($json, 'Articles_aggregated');

        // Return both the articles and pagination information
        return [
            'articles' => $json['data']['Articles'] ?? [],
            'pagination' => [
                'total' => $totalCount,
                'page' => $page,
                'pageSize' => $pageSize,
                'totalPages' => max(1, ceil($totalCount / $pageSize))
            ]
        ];
    }

    /**
     * Fetch news articles filtered by tag with pagination
     *
     * @param string $tag Tag to filter by
     * @param int $page Page number (starting from 1)
     * @param int $pageSize Number of items per page
     * @return array
     */
    public function fetchNewsByTag(string $tag, int $page = 1, int $pageSize = 12): array
    {
        $cacheKey = $this->getCachePrefix('Articles') . "tag_{$tag}_page{$page}_size{$pageSize}";

        // Calculate offset based on page number
        $offset = ($page - 1) * $pageSize;

        // For JSON array fields in Directus, we need to construct a filter
        $query = [
            'query' => 'query GetFilteredArticles($limit: Int!, $offset: Int!, $tag: String!) {
                Articles (
                    filter: {
                        status: {_eq: "published"},
                        tags: {_contains: $tag}
                    },
                    limit: $limit,
                    offset: $offset,
                    sort: "-date_created"
                ) {
                    id,
                    date_created,
                    title,
                    status,
                    lead,
                    tags,
                    slug,
                    thumbnail {
                        id
                    }
                }
            }',
            'variables' => [
                'limit' => $pageSize,
                'offset' => $offset,
                'tag' => $tag
            ]
        ];

        $json = $this->executeQuery($query, $cacheKey);

        if (isset($json['errors'])) {
            Log::error('GraphQL error in fetchNewsByTag: ' . json_encode($json['errors']));
            // Fall back to explicit filtering
            return $this->fetchNewsByTagExplicit($tag, $page, $pageSize);
        }

        $articles = $json['data']['Articles'] ?? [];

        // Now make a separate count query to get the total
        $countCacheKey = $this->getCachePrefix('Articles') . "tag_{$tag}_count";
        $countQuery = [
            'query' => 'query CountFilteredArticles($tag: String!) {
                Articles (
                    filter: {
                        status: {_eq: "published"},
                        tags: {_contains: $tag}
                    }
                ) {
                    id
                }
            }',
            'variables' => [
                'tag' => $tag
            ]
        ];

        $countJson = $this->executeQuery($countQuery, $countCacheKey);
        $totalCount = isset($countJson['data']['Articles']) ? count($countJson['data']['Articles']) : count($articles);

        // Return both the articles and pagination information
        return [
            'articles' => $articles,
            'pagination' => [
                'total' => $totalCount,
                'page' => $page,
                'pageSize' => $pageSize,
                'totalPages' => max(1, ceil($totalCount / $pageSize)),
                'filter' => ['tag' => $tag]
            ]
        ];
    }

    /**
     * Explicit tag search implementation as a last resort
     */
    private function fetchNewsByTagExplicit(string $tag, int $page = 1, int $pageSize = 12): array
    {
        $cacheKey = $this->getCachePrefix('Articles') . "tag_explicit_{$tag}_page{$page}_size{$pageSize}";

        return Cache::remember($cacheKey, now()->addMinutes($this->cacheDuration), function () use ($tag, $page, $pageSize) {
            // Calculate offset based on page number
            $offset = ($page - 1) * $pageSize;

            // Fetch all articles and filter manually
            $query = [
                'query' => 'query GetAllArticles {
                    Articles (
                        filter: {status: {_eq: "published"}},
                        limit: 1000,
                        sort: "-date_created"
                    ) {
                        id,
                        date_created,
                        title,
                        status,
                        lead,
                        tags,
                        slug,
                        thumbnail {
                            id
                        }
                    }
                }'
            ];

            Log::info('Trying explicit tag filtering as last resort for tag: ' . $tag);

            try {
                $response = $this->client->post($this->url, [
                    'json' => $query,
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('DIRECTUS_API_TOKEN'),
                        'Content-Type' => 'application/json'
                    ]
                ]);

                $json = json_decode($response->getBody()->getContents(), true);
                $allArticles = $json['data']['Articles'] ?? [];

                // Manually filter articles by tag
                $filteredArticles = [];
                foreach ($allArticles as $article) {
                    if (isset($article['tags']) && is_array($article['tags'])) {
                        if (in_array($tag, $article['tags'])) {
                            $filteredArticles[] = $article;
                        }
                    }
                }

                // Apply pagination manually
                $totalCount = count($filteredArticles);
                $paginatedArticles = array_slice($filteredArticles, $offset, $pageSize);

                Log::info('Found ' . $totalCount . ' articles with tag: ' . $tag);

                // Return both the articles and pagination information
                return [
                    'articles' => $paginatedArticles,
                    'pagination' => [
                        'total' => $totalCount,
                        'page' => $page,
                        'pageSize' => $pageSize,
                        'totalPages' => max(1, ceil($totalCount / $pageSize)),
                        'filter' => ['tag' => $tag]
                    ]
                ];
            }
            catch (\Exception $e) {
                Log::error('Error with explicit filtering: ' . $e->getMessage());
                return $this->getEmptyPaginationResult($page, $pageSize, ['tag' => $tag]);
            }
        });
    }

    /**
     * Fetch a single news article by slug
     *
     * @param string $slug Article slug
     * @return array
     */
    public function fetchNewsArticleBySlug(string $slug): array
    {
        $cacheKey = $this->getCachePrefix('Articles') . "slug_{$slug}";
        $duration = $this->cacheDuration * 2; // Cache single articles longer

        $query = [
            'query' => "query GetSingleArticle {
                Articles(filter: {
                    slug: {_eq: \"$slug\"},
                    status: {_eq: \"published\"}
                }) {
                    id,
                    date_created,
                    title,
                    lead,
                    content,
                    tags,
                    thumbnail {
                        id,
                        title,
                        width,
                        height
                    }
                }
            }"
        ];

        $json = $this->executeQuery($query, $cacheKey, $duration);

        if (isset($json['errors'])) {
            Log::error('GraphQL error in fetchNewsArticleBySlug: ' . json_encode($json['errors']));
            throw new \Exception('Article not found');
        }

        if (empty($json['data']['Articles'])) {
            throw new \Exception('Article not found');
        }

        return $json['data']['Articles'][0];
    }

    /**
     * Fetch job listings with pagination
     *
     * @param int $page Page number (starting from 1)
     * @param int $pageSize Number of items per page
     * @return array
     */
    public function fetchJobs(int $page = 1, int $pageSize = 12): array
    {
        $cacheKey = $this->getCachePrefix('Jobs') . "page{$page}_size{$pageSize}";

        // Calculate offset based on page number
        $offset = ($page - 1) * $pageSize;

        // Query with correct aggregation structure
        $query = [
            'query' => 'query GetPaginatedJobs($limit: Int!, $offset: Int!) {
                Jobs (
                    filter: {status: {_eq: "published"}},
                    limit: $limit,
                    offset: $offset,
                    sort: "-date_created"
                ) {
                    id,
                    date_created,
                    title,
                    slug,
                    short_description,
                    type,
                    availability,
                    location
                }
                Jobs_aggregated(filter: {status: {_eq: "published"}}) {
                    count {
                        id
                    }
                }
            }',
            'variables' => [
                'limit' => $pageSize,
                'offset' => $offset
            ]
        ];

        $json = $this->executeQuery($query, $cacheKey);

        if (isset($json['errors'])) {
            Log::error('GraphQL error in fetchJobs: ' . json_encode($json['errors']));
            return $this->getEmptyPaginationResult($page, $pageSize);
        }

        // Extract the count from the correct location in the response
        $totalCount = $this->extractTotalCount($json, 'Jobs_aggregated');

        // Return both the jobs and pagination information
        return [
            'jobs' => $json['data']['Jobs'] ?? [],
            'pagination' => [
                'total' => $totalCount,
                'page' => $page,
                'pageSize' => $pageSize,
                'totalPages' => max(1, ceil($totalCount / $pageSize))
            ]
        ];
    }

    /**
     * Fetch job listings filtered by job type with pagination
     *
     * @param string $jobType Type to filter by (e.g., "full-time", "part-time")
     * @param int $page Page number (starting from 1)
     * @param int $pageSize Number of items per page
     * @return array
     */
    public function fetchJobsByType(string $jobType, int $page = 1, int $pageSize = 12): array
    {
        $cacheKey = $this->getCachePrefix('Jobs') . "type_{$jobType}_page{$page}_size{$pageSize}";

        // Calculate offset based on page number
        $offset = ($page - 1) * $pageSize;

        $query = [
            'query' => 'query GetFilteredJobs($limit: Int!, $offset: Int!, $jobType: String!) {
                Jobs (
                    filter: {
                        status: {_eq: "published"},
                        job_type: {_eq: $jobType}
                    },
                    limit: $limit,
                    offset: $offset,
                    sort: "-date_created"
                ) {
                    id,
                    date_created,
                    title,
                    slug,
                    short_description,
                    type,
                    availability,
                    location
                }
                Jobs_aggregated(filter: {
                    status: {_eq: "published"},
                    job_type: {_eq: $jobType}
                }) {
                    count {
                        id
                    }
                }
            }',
            'variables' => [
                'limit' => $pageSize,
                'offset' => $offset,
                'jobType' => $jobType
            ]
        ];

        $json = $this->executeQuery($query, $cacheKey);

        if (isset($json['errors'])) {
            Log::error('GraphQL error in fetchJobsByType: ' . json_encode($json['errors']));
            return $this->getEmptyPaginationResult($page, $pageSize, ['job_type' => $jobType]);
        }

        // Extract the count from the correct location in the response
        $totalCount = $this->extractTotalCount($json, 'Jobs_aggregated');

        // Return both the jobs and pagination information
        return [
            'jobs' => $json['data']['Jobs'] ?? [],
            'pagination' => [
                'total' => $totalCount,
                'page' => $page,
                'pageSize' => $pageSize,
                'totalPages' => max(1, ceil($totalCount / $pageSize)),
                'filter' => ['job_type' => $jobType]
            ]
        ];
    }

    /**
     * Fetch a single job posting by slug
     *
     * @param string $slug Job posting slug
     * @return array
     */
    public function fetchJobBySlug(string $slug): array
    {
        $cacheKey = $this->getCachePrefix('Jobs') . "slug_{$slug}";
        $duration = $this->cacheDuration * 2; // Cache single job listings longer

        $query = [
            'query' => "query GetSingleJob {
                Jobs(filter: {
                    slug: {_eq: \"$slug\"},
                    status: {_eq: \"published\"}
                }) {
                    id,
                    date_created,
                    title,
                    slug,
                    type,
                    availability,
                    location,
                    short_description,
                    full_description
                }
            }"
        ];

        $json = $this->executeQuery($query, $cacheKey, $duration);

        if (isset($json['errors'])) {
            Log::error('GraphQL error in fetchJobBySlug: ' . json_encode($json['errors']));
            throw new \Exception('Job posting not found');
        }

        if (empty($json['data']['Jobs'])) {
            throw new \Exception('Job posting not found');
        }

        return $json['data']['Jobs'][0];
    }

    /**
     * Extract total count from aggregated response
     *
     * @param array $json Response JSON
     * @param string $aggregationKey Key for the aggregated data
     * @return int
     */
    protected function extractTotalCount(array $json, string $aggregationKey): int
    {
        $totalCount = 0;

        if (isset($json['data'][$aggregationKey][0]['count']['id'])) {
            $totalCount = $json['data'][$aggregationKey][0]['count']['id'];
        } elseif (isset($json['data'][$aggregationKey]['count']['id'])) {
            $totalCount = $json['data'][$aggregationKey]['count']['id'];
        } else {
            // Fallback value if we can't determine the count from aggregation
            $collectionKey = str_replace('_aggregated', '', $aggregationKey);
            $totalCount = count($json['data'][$collectionKey] ?? []);
            Log::warning("Could not determine total count for {$collectionKey} from aggregation");
        }

        return $totalCount;
    }

    /**
     * Get empty pagination result array with default values
     *
     * @param int $page Current page
     * @param int $pageSize Page size
     * @param array $filter Optional filter information
     * @return array
     */
    protected function getEmptyPaginationResult(int $page, int $pageSize, array $filter = []): array
    {
        $result = [
            'pagination' => [
                'total' => 0,
                'page' => $page,
                'pageSize' => $pageSize,
                'totalPages' => 1
            ]
        ];

        if (!empty($filter)) {
            $result['pagination']['filter'] = $filter;
        }

        // Add empty data array with key based on context
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $backtrace[1]['function'] ?? '';

        if (strpos($caller, 'fetchJobs') === 0) {
            $result['jobs'] = [];
        } else {
            $result['articles'] = [];
        }

        return $result;
    }

    /**
     * Manually clear the cache for specific items or collections
     *
     * @param string $collection Collection name ('Articles' or 'Jobs')
     * @param string|null $identifier Optional specific item identifier (slug, id)
     * @return bool
     */
    public function clearCache(string $collection, ?string $identifier = null): bool
    {
        $prefix = $this->getCachePrefix($collection);

        if ($identifier) {
            // Clear specific item cache
            $cacheKeys = [
                $prefix . "slug_{$identifier}",
                $prefix . "id_{$identifier}"
            ];

            foreach ($cacheKeys as $key) {
                Cache::forget($key);
            }

            Log::info("Cleared cache for {$collection} with identifier: {$identifier}");
        } else {
            // Clear all cache for the collection
            Cache::flush($prefix . "*");
            Log::info("Cleared all cache for {$collection}");
        }

        return true;
    }
}
