<?php

namespace App\Livewire\Components\User;

use Livewire\Component;
use App\Models\Comment;

class UserComment extends Component
{

    public Comment $comment;

    public function render()
    {
        $this->comment->load('user', 'post');

        // Shorten the comment content if it has more characters than 500, and add ...
        if (strlen($this->comment->content) > 500) {
            $this->comment->content = substr($this->comment->content, 0, 500) . '...';
        }

        return view('livewire.components.user.user-comment');
    }
}
