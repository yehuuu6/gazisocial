<?php

namespace App\Livewire\Auth\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Şifremi Sıfırla')]
class ResetPassword extends Component
{

    use LivewireAlert;

    public $token = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function resetPassword()
    {
        try {
            $this->validate([
                'email' => 'required|email',
                'password' => 'required|min:8|confirmed',
                'token' => 'required',
            ]);
        } catch (ValidationException $e) {
            $this->alert('error', $e->validator->errors()->first());
            return;
        }

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );


        if ($status === Password::PASSWORD_RESET) {
            $this->flash('success', 'Şifreniz başarıyla sıfırlandı!', redirect: route('login'));
        } else {
            $this->alert('error', 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
        }
    }

    #[Layout('layout.auth')]
    public function render()
    {
        return view('livewire.auth.pages.reset-password');
    }
}
