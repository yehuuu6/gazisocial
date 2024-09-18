<?php

namespace App\Livewire\Pages\Users;

use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UserPage extends Component
{

    use LivewireAlert;

    public User $user;

    public function render()
    {
        if (session()->has('post-deleted')) {
            $this->alert('success', session('post-deleted'));
        }

        return view('livewire.pages.users.user-page')->title($this->user->name . ' - ' . config('app.name'));
    }
}
