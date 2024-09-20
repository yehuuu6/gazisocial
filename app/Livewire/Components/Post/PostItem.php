<?php

namespace App\Livewire\Components\Post;

use App\Models\Post;
use Livewire\Component;

class PostItem extends Component
{

    public Post $post;

    public function getTagColor(string $color)
    {
        return "bg-$color-500";
    }

    public function render()
    {
        return view('livewire.components.post.post-item');
    }
}
