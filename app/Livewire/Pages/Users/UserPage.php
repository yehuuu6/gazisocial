<?php

namespace App\Livewire\Pages\Users;

use App\Models\User;
use Livewire\Component;

class UserPage extends Component
{

    public User $user;

    public function render()
    {
        return view('livewire.pages.users.user-page')->title($this->user->name . ' - ' . config('app.name'));
    }
}
