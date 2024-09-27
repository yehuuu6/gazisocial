<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Tag;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Component;

class ShowPostsByTag extends Component
{

    use WithPagination, WithoutUrlPagination;

    public Tag $tag;

    public function render()
    {
        return view('livewire.pages.posts.show-posts-by-tag', [
            'posts' => $this->tag->posts()
                ->with('user')
                ->with('tags')
                ->latest('created_at')
                ->simplePaginate(20)
        ]);
    }
}
