<?php

namespace App\Livewire\Pages\Users;

use App\Models\User;
use Livewire\Component;

class EditUser extends Component
{

    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;

        $this->authorize('view', $this->user);
    }

    public function render()
    {
        return view('livewire.pages.users.edit-user');
    }
}
