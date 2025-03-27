<?php

namespace App\Livewire\Auth\Pages;

use App\Models\User;
use App\Rules\ReChaptcha;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Masmerise\Toaster\Toaster;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Renderless;

#[Title('Kayıt Ol')]
class Register extends Component
{
    use WithRateLimiting;

    public $name;
    public $username;
    public $email;
    public $gender;
    public $password;
    public $password_confirmation;
    public $accept_terms = false;
    public $recaptchaToken;

    #[Renderless]
    public function register()
    {

        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
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
            'gender.required' => 'Cinsiyet alanı boş bırakılamaz.',
            'gender.string' => 'Cinsiyet alanı metin tipinde olmalıdır.',
            'gender.in' => 'Cinsiyet alanı sadece :values değerlerinden biri olabilir.',
        ];

        try {
            $this->validate([
                'name' => 'required|string|max:30',
                'username' => 'required|string|max:16|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'accept_terms' => 'required|accepted',
                'gender' => 'required|string|in:erkek,kadın,belirtilmemiş',
                'recaptchaToken' => [new ReChaptcha()],
            ], $messages);
        } catch (ValidationException $e) {
            $message = $e->getMessage();
            Toaster::error($message);
            return;
        }

        $attributes = [
            'name' => $this->name,
            'username' => $this->username,
            'gender' => $this->gender,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ];

        $user = User::create($attributes);

        Auth::login($user);

        event(new Registered($user));

        return redirect(route('verification.notice'))->info(
            'Kayıt oldunuz, e-posta doğrulaması için lütfen postanızı kontrol edin.'
        );
    }

    #[Layout('layout.auth')]
    public function render()
    {
        return view('livewire.auth.pages.register');
    }
}
