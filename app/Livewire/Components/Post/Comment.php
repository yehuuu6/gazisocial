<?php

namespace App\Livewire\Components\Post;

use Livewire\Component;

class Comment extends Component
{

    public $comment;
    public $username;
    public $time;

    public function render()
    {
        $this->username = "@{$this->comment->user->username}";
        $this->time = $this->comment->created_at->diffForHumans();

        return view('livewire.components.post.comment');
    }
}
