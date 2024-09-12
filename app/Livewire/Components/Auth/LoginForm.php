<?php

namespace App\Livewire\Components\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class LoginForm extends Component
{

    use LivewireAlert;

    public $email;
    public $password;

    public function logout()
    {
        Auth::logout();

        return redirect(route('login'));
    }

    public function login()
    {
        $messages = [
            'email.required' => 'Email alanı boş bırakılamaz.',
            'email.email' => 'Geçerli bir email adresi giriniz.',
            'password.required' => 'Şifre alanı boş bırakılamaz.',
        ];

        try {
            $this->validate([
                'email' => 'required|email',
                'password' => 'required',
            ], $messages);
        } catch (ValidationException $e) {
            $this->alert('error', $e->getMessage());
            return;
        }

        $attributes = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (! Auth::attempt($attributes)) {
            $this->alert('error', 'Üzgünüz, bu bilgilerle hesap bulunamadı.');
            return;
        }

        $this->alert('success', 'Başarıyla giriş yaptınız.');

        request()->session()->regenerate();

        return redirect(route('home'));
    }

    public function render()
    {
        return view('livewire.components.auth.login-form');
    }
}
