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
use Masmerise\Toaster\Toaster;

#[Title('Şifremi Sıfırla')]
class ResetPassword extends Component
{
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
            Toaster::error($e->validator->errors()->first());
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
            return redirect(route('login'))->success('Şifrenizi sıfırladınız. Yeni şifreniz ile giriş yapabilirsiniz.');
        } else {
            Toaster::error('Şifre sıfırlama işlemi başarısız oldu!');
        }
    }

    #[Layout('layout.auth')]
    public function render()
    {
        return view('livewire.auth.pages.reset-password');
    }
}
