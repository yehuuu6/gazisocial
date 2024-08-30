<?php

namespace App\Livewire\Components\Post;

use Livewire\Component;

class Comment extends Component
{

    public $comment;

    public function render()
    {
        return view('livewire.components.post.comment');
    }
}
