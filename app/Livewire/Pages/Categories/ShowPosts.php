<?php

namespace App\Livewire\Pages\Categories;

use App\Models\Tag;
use Livewire\WithPagination, Livewire\WithoutUrlPagination, Livewire\Component;

class ShowPosts extends Component
{

    use WithPagination, WithoutUrlPagination;

    public Tag $tag;

    public function render()
    {
        return view('livewire.pages.categories.show-posts', [
            'posts' => $this->tag->posts()->with('user')->withCount('comments')->latest('created_at')->simplePaginate(10)
        ]);
    }
}
