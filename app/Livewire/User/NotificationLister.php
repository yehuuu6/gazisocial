<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Computed;

class NotificationLister extends Component
{
    #[Computed]
    public function notifications()
    {
        return Auth::user()->notifications;
    }

    public function render()
    {
        return view('livewire.user.notification-lister');
    }
}
