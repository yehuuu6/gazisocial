<?php

namespace App\Livewire\Pages\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;

#[Title('Şifremi Unuttum')]
class ForgotPassword extends Component
{

    use LivewireAlert;

    public $email = '';

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
            ], $messages);
        } catch (ValidationException $e) {
            $this->alert('error', $e->validator->errors()->first());
            return;
        }

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->alert('info', 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.');
        } else {
            $this->alert('error', 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
        }
    }

    #[Layout('layout.auth')]
    public function render()
    {
        return view('livewire.pages.auth.forgot-password');
    }
}
