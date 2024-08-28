<?php

namespace App\Livewire\Pages\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('Giriş Yap')]
class Login extends Component
{
    #[Layout('layout.auth')]
    public function render()
    {
        return view('livewire.pages.auth.login');
    }
}
