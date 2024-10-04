<?php

namespace App\Livewire\Components\User;

use Livewire\Component;

class LikedPost extends Component
{

    public $like;

    public function render()
    {
        return view('livewire.components.user.liked-post');
    }
}
