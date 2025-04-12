<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;

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

        $users = User::where('is_banned', false)
            ->latest()
            ->limit(1000) // Limit to most recent 1000 users
            ->get();

        return response()->view('sitemap.index', [
            'posts' => $posts,
            'users' => $users,
        ])->header('Content-Type', 'text/xml');
    }
}
