<?php

namespace App\Livewire\Auth\Pages;

use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

#[Title('E-posta Adresinizi Doğrulayın')]
class Verify extends Component
{
    use WithRateLimiting;

    #[Layout('layout.auth')]

    #[Validate('required|size:6|regex:/^[0-9]+$/', 
        message: [
            'required' => 'Doğrulama kodu gereklidir.',
            'size' => 'Doğrulama kodu 6 haneli olmalıdır.',
            'regex' => 'Doğrulama kodu sadece rakamlardan oluşmalıdır.'
        ]
    )]
    public $verification_code = '';

    protected User $user;

    public function mount()
    {
        $this->returnHomeIfVerified();
    }

    public function verifyCode()
    {
        $this->validate();

        $this->user = Auth::user();

        if ($this->user->verifyCode($this->verification_code)) {
            // If user has @gazi.edu.tr email, assign gazili role
            if (strpos($this->user->email, '@gazi.edu.tr') !== false) {
                // Check if user already has gazili role
                if (!$this->user->isStudent()) {
                    $this->user->assignRole(['gazili']);
                }
            }

            // Update user's last activity
            $this->user->heartbeat();

            if ($this->user->isStudent()) {
                $msg = "E-posta adresiniz doğrulandı. Artık bir fakülteye katılabilirsiniz.";
            } else {
                $msg = "E-posta adresiniz doğrulandı.";
            }

            return redirect(route('home'))->success($msg);
        }

        Toaster::error('Geçersiz doğrulama kodu. Lütfen tekrar deneyin.');
    }

    public function sendVerifyMail(Request $request)
    {
        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        $request->user()->sendEmailVerificationNotification();

        Toaster::info('Doğrulama e-postası gönderildi.');
    }

    protected function returnHomeIfVerified()
    {
        $this->user = Auth::user();
        // If user is verified, redirect to home page
        if ($this->user->hasVerifiedEmail()) {
            return redirect(route('home'))->warning('E-posta adresiniz zaten doğrulanmış.');
        }
    }

    public function render()
    {
        return view('livewire.auth.pages.verify');
    }
}
