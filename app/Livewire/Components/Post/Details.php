<?php

namespace App\Livewire\Components\Post;

use App\Models\Post;
use Livewire\Component;

class Details extends Component
{

    public Post $post;

    public function render()
    {
        return view('livewire.components.post.details');
    }
}
