<?php

namespace App\Livewire\Pages\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Register extends Component
{
    #[Layout('layout.auth')]
    public function render()
    {
        return view('livewire.pages.auth.register');
    }
}
