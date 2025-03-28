<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GiphyController extends Controller
{
    private Client $client;
    private const CACHE_TTL = 3600; // 1 saat
    private const TRENDING_CACHE_TTL = 7200; // 2 saat

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.giphy.com/v1/gifs/',
        ]);
    }

    public function search(string $query)
    {
        $cacheKey = "giphy_search_" . md5($query);

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($query) {
            try {
                $response = $this->client->get('search', [
                    'query' => [
                        'api_key' => config('services.giphy.token'),
                        'q' => $query,
                        'limit' => 20,
                    ],
                ]);

                return json_decode($response->getBody()->getContents(), true)['data'];
            } catch (ClientException $e) {
                Log::error('Giphy API Error: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function trending()
    {
        return Cache::remember('giphy_trending', self::TRENDING_CACHE_TTL, function () {
            try {
                $response = $this->client->get('trending', [
                    'query' => [
                        'api_key' => config('services.giphy.token'),
                        'limit' => 20,
                    ],
                ]);

                return json_decode($response->getBody()->getContents(), true)['data'];
            } catch (ClientException $e) {
                Log::error('Giphy API Error: ' . $e->getMessage());
                return [];
            }
        });
    }
}
