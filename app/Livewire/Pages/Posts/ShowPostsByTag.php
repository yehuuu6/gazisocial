<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Tag;
use Livewire\Component;

class ShowPostsByTag extends Component
{

    public Tag $tag;

    public function render()
    {
        return view('livewire.pages.posts.show-posts-by-tag');
    }
}
