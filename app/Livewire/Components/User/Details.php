<?php

namespace App\Livewire\Components\User;

use App\Models\User;
use Livewire\Component;

class Details extends Component
{

    public User $user;

    public function render()
    {
        return view('livewire.components.user.details');
    }
}
