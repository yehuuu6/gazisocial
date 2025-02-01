<?php

namespace App\Livewire\Auth\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Illuminate\Support\Facades\Redirect;

#[Title('Giriş Yap')]
class Login extends Component
{
    use WithRateLimiting;

    public $email;
    public $password;

    public function logout()
    {
        Auth::logout();

        return redirect(route('login'))->info('Hesabınızdan çıkış yaptınız.');
    }

    public function login()
    {

        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
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
            Toaster::error($e->getMessage());
            return;
        }

        $attributes = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (! Auth::attempt($attributes)) {
            Toaster::error('Giriş bilgileri hatalı. Lütfen kontrol edip tekrar deneyin.');
            return;
        }

        session()->regenerate();

        return Redirect::route('home')->success(
            'Giriş yapıldı, hoş geldin ' . Auth::user()->name . '! 🎉'
        );
    }

    #[Layout('layout.auth')]
    public function render()
    {
        return view('livewire.auth.pages.login');
    }
}
