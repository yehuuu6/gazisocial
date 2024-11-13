<?php

namespace App\Livewire\Components\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class RegisterForm extends Component
{

    use LivewireAlert, WithRateLimiting;

    public $name;
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $accept_terms = false;

    public function register()
    {

        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        $messages = [
            'name.required' => 'Ad alanı boş bırakılamaz.',
            'name.string' => 'Ad alanı metin tipinde olmalıdır.',
            'name.max' => 'Ad alanı en fazla :max karakter olabilir.',
            'username.required' => 'Kullanıcı adı alanı boş bırakılamaz.',
            'username.string' => 'Kullanıcı adı alanı metin tipinde olmalıdır.',
            'username.max' => 'Kullanıcı adı alanı en fazla :max karakter olabilir.',
            'username.unique' => 'Bu kullanıcı adı zaten alınmış.',
            'email.required' => 'Email alanı boş bırakılamaz.',
            'email.string' => 'Email alanı metin tipinde olmalıdır.',
            'email.email' => 'Geçerli bir email adresi giriniz.',
            'email.max' => 'Email alanı en fazla :max karakter olabilir.',
            'email.unique' => 'Bu email adresi zaten alınmış.',
            'password.required' => 'Şifre alanı boş bırakılamaz.',
            'password.string' => 'Şifre alanı metin tipinde olmalıdır.',
            'password.min' => 'Şifre alanı en az :min karakter olabilir.',
            'password.confirmed' => 'Şifreler uyuşmuyor.',
            'accept_terms.required' => 'Kullanıcı sözleşmesini kabul etmelisiniz.',
            'accept_terms.accepted' => 'Kullanıcı sözleşmesini kabul etmelisiniz.',
        ];

        try {
            $this->validate([
                'name' => 'required|string|max:30',
                'username' => 'required|string|max:30|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'accept_terms' => 'required|accepted',
            ], $messages);
        } catch (ValidationException $e) {
            $message = $e->getMessage();
            $this->alert('error', $message);
            return;
        }

        if ($this->username == "anonymous") {
            $this->alert('error', 'Bu kullanıcı adı kullanılamaz.');
            return;
        }

        $attributes = [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ];

        $attributes['avatar'] = 'https://ui-avatars.com/api/?name=' . $attributes['name'] . '&color=7F9CF5&background=random';

        $user = User::create($attributes);

        Auth::login($user);

        event(new Registered($user));

        $this->flash('success', 'Başarıyla kayıt oldunuz.', redirect: route('verification.notice'));
    }

    public function render()
    {
        return view('livewire.components.auth.register-form');
    }
}
