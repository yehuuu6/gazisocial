<?php

namespace App\Livewire\Components\Post;

use App\Models\Post;
use Livewire\Component;

class Details extends Component
{

    public Post $post;

    public string $username;

    public string $time;

    public function render()
    {
        $this->username = "@{$this->post->user->username}";
        $this->time = $this->post->created_at->diffForHumans();
        return view('livewire.components.post.details');
    }
}
