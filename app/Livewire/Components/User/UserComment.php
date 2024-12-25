<?php

namespace App\Livewire\Components\User;

use Livewire\Component;
use App\Models\Comment;

class UserComment extends Component
{

    public Comment $comment;

    public function render()
    {
        $this->comment->load('post:id,title');

        return view('livewire.components.user.user-comment');
    }
}
