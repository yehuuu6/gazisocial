<?php

namespace App\Livewire\Post\Indexer;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class PostIndexer extends Component
{
    use WithPagination;

    public function placeholder()
    {
        return view('components.post.indexer-placeholder');
    }

    #[Computed]
    public function posts()
    {
        return Post::with('user', 'tags')
            ->latest()
            ->simplePaginate(20);
    }

    public function render()
    {
        return view('livewire.post.indexer.post-indexer');
    }
}
