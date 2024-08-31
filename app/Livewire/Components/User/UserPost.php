<?php

namespace App\Livewire\Components\User;

use App\Models\Post;
use Livewire\Component;

class UserPost extends Component
{

    public Post $post;

    public function render()
    {
        return view('livewire.components.user.user-post');
    }
}
