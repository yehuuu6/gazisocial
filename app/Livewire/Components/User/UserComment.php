<?php

namespace App\Livewire\Components\User;

use Livewire\Component;
use App\Models\Comment;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserComment extends Component
{

    use LivewireAlert;

    public Comment $comment;

    public function render()
    {
        $this->comment->load('user', 'post');

        return view('livewire.components.user.user-comment');
    }
}
