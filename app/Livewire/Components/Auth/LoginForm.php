<?php

namespace App\Livewire\Components\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginForm extends Component
{

    public $email;
    public $password;

    public function logout(){
        Auth::logout();

        return redirect(route('login'));
    }

    public function login()
    {
        $attributes = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Üzgünüz, bu bilgilerle hesap bulunamadı.',
            ]);
        }

        request()->session()->regenerate();

        return redirect(route('home'));
    }

    public function render()
    {
        return view('livewire.components.auth.login-form');
    }
}
