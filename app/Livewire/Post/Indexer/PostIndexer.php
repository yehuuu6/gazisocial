<?php

namespace App\Livewire\Post\Indexer;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostIndexer extends Component
{
    use WithPagination;

    public function placeholder()
    {
        return view('components.post.indexer-placeholder');
    }

    public function updatingPage()
    {
        $this->dispatch('scroll-to-top');
    }

    public function fetchPosts()
    {
        return Post::with('user', 'tags')
            ->latest()
            ->simplePaginate(20);
    }

    public function render()
    {
        return view('livewire.post.indexer.post-indexer', [
            'posts' => $this->fetchPosts(),
        ]);
    }
}
