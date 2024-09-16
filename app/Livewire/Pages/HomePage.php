<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class HomePage extends Component
{
    use WithPagination;

    public function updatingPage()
    {
        $this->dispatch('scroll-to-top');
    }

    public function fetchPosts()
    {
        return Post::query()
            ->select('id', 'user_id', 'title', 'content', 'created_at')
            ->with('user:id,name,avatar,username')
            ->with('tags:id,name')
            ->withCount('comments')
            ->latest('created_at')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.pages.home-page', [
            'posts' => $this->fetchPosts(),
        ]);
    }
}
