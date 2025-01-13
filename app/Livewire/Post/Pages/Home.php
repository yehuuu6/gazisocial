<?php

namespace App\Livewire\Post\Pages;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Computed;

class Home extends Component
{

    #[Computed]
    public function pinnedPosts()
    {
        return Post::with('user', 'tags')
            ->where('is_pinned', true)
            ->latest()
            ->limit(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.post.pages.home');
    }
}
