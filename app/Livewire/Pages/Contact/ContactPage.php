<?php

namespace App\Livewire\Pages\Contact;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

#[Title('İletişime geç - Gazi Social')]
class ContactPage extends Component
{

    use LivewireAlert, WithRateLimiting;

    public string $name = '';
    public string $email = '';
    public string $message = '';

    public function mount()
    {
        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }
    }

    public function sendMessage()
    {

        try {
            $this->rateLimit(5, decaySeconds: 180);
        } catch (TooManyRequestsException $exception) {
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        $messages = [
            'name.required' => 'İsim alanı boş bırakılamaz.',
            'name.min' => 'İsim alanı en az :min karakter olmalıdır.',
            'name.max' => 'İsim alanı en fazla :max karakter olmalıdır.',
            'email.required' => 'E-posta alanı boş bırakılamaz.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'message.required' => 'Mesaj alanı boş bırakılamaz.',
            'message.min' => 'Mesaj alanı en az :min karakter olmalıdır.',
            'message.max' => 'Mesaj alanı en fazla :max karakter olmalıdır.',
        ];

        try {
            $this->validate([
                'name' => ['required', 'min:3', 'max:255'],
                'email' => ['required', 'email'],
                'message' => ['required', 'min:10', 'max:5000'],
            ], $messages);
        } catch (ValidationException $e) {
            $this->alert('error', $e->getMessage());
            return;
        }

        $validated = [
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ];

        ContactMessage::create([
            ...$validated
        ]);

        $this->alert('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapılacaktır.');

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.pages.contact.contact-page');
    }
}
