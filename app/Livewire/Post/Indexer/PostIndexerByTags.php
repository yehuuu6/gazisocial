<?php

namespace App\Livewire\Post\Indexer;

use App\Models\Tag;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class PostIndexerByTags extends Component
{

    use WithPagination;

    public Tag $tag;

    #[Computed]
    public function posts()
    {
        return Post::with('user', 'tags')
            ->whereHas('tags', function ($query) {
                $query->where('tags.id', $this->tag->id); // Specify the table name for the id column
            })
            ->latest()
            ->simplePaginate(20);
    }

    public function placeholder()
    {
        return view('components.post.indexer-placeholder');
    }

    public function render()
    {
        return view('livewire.post.indexer.post-indexer-by-tags');
    }
}
