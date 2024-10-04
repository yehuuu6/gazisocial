<?php

namespace App\Livewire\Components\User;

use Livewire\Component;

class LikedReply extends Component
{

    public $like;

    public function render()
    {
        return view('livewire.components.user.liked-reply');
    }
}
