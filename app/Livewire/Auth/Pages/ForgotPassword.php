<?php

namespace App\Livewire\Auth\Pages;

use App\Rules\ReChaptcha;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Password;
use Masmerise\Toaster\Toaster;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Renderless;

#[Title('Şifremi Unuttum')]
class ForgotPassword extends Component
{
    public $email = '';
    public $recaptchaToken;

    #[Renderless]
    public function sendPasswordResetLink()
    {

        $messages = [
            'email.required' => 'E-posta adresi alanı boş bırakılamaz.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.max' => 'E-posta adresi en fazla :max karakter olabilir.',
        ];

        try {
            $this->validate([
                'email' => 'required|email|max:255',
                'recaptchaToken' => [new ReChaptcha()],
            ], $messages);
        } catch (ValidationException $e) {
            $message = $e->getMessage();
            Toaster::error($message);
            return;
        }

        try {
            $status = Password::sendResetLink(['email' => $this->email]);
        } catch (ValidationException $e) {
            $message = $e->getMessage();
            Toaster::error($message);
            return;
        }

        // Always display the same message
        Toaster::info('Eğer bu e-posta adresine kayıtlı bir hesap bulunuyorsa, şifre sıfırlama bağlantısı gönderilecektir.');
    }

    #[Layout('layout.auth')]
    public function render()
    {
        return view('livewire.auth.pages.forgot-password');
    }
}
