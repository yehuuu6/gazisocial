<?php

namespace App\Livewire\Auth\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

#[Title('Giriş Yap')]
class Login extends Component
{
    use LivewireAlert, WithRateLimiting;

    public $email;
    public $password;

    public function logout()
    {
        Auth::logout();

        session()->flash('loggedOut', 'Hesabınızdan çıkış yaptınız.');

        return redirect(route('login'));
    }

    public function login()
    {

        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

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

        session()->regenerate();

        $this->flash('success', 'Başarıyla giriş yaptınız.', redirect: route('home'));
    }

    #[Layout('layout.auth')]
    public function render()
    {

        if (session()->has('loggedOut')) {
            $this->alert('info', session('loggedOut'));
        }

        return view('livewire.auth.pages.login');
    }
}
