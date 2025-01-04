<?php

namespace App\Livewire\Post\Pages;

use App\Models\Tag;
use Livewire\Component;

class ShowPostsByTag extends Component
{

    public Tag $tag;

    public function render()
    {
        return view('livewire.post.pages.show-posts-by-tag');
    }
}
