<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;
use Livewire\Attributes\Computed;

class HomePage extends Component
{
    #[Computed(persist: true)]
    public function popularTags()
    {
        // Get most popular 4 tags
        return Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(8)->get();
    }

    #[Computed]
    public function pinnedPosts()
    {
        return Post::with('user', 'tags')
            ->where('is_pinned', true)
            ->latest()
            ->limit(3)
            ->get();
    }
}
