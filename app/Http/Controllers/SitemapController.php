<?php

namespace App\Http\Controllers;

use App\Models\Post;

class SitemapController extends Controller
{
    public function index()
    {
        // Get popular posts first - using likes_count as popularity metric
        $posts = Post::where('is_published', true)
            ->orderBy('popularity', 'desc')
            ->orderBy('created_at', 'desc') // Secondary sort by recency
            ->limit(1000) // Limit to most popular 1000 posts
            ->get();

        return response()->view('sitemap.index', [
            'posts' => $posts
        ])->header('Content-Type', 'text/xml');
    }
}
