<?php

namespace App\Livewire\Auth\Pages;

use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Masmerise\Toaster\Toaster;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

#[Title('E-posta Adresinizi Doğrulayın')]
class Verify extends Component
{
    use WithRateLimiting;

    #[Layout('layout.auth')]

    protected User $user;

    public function mount()
    {
        $this->returnHomeIfVerified();
    }

    public function verifyUser(EmailVerificationRequest $request)
    {
        $request->fulfill();
        $this->user = Auth::user();
        // if user has @gazi.edu.tr email, assign gazili role
        if (strpos($this->user->email, '@gazi.edu.tr') !== false) {
            // Check if user already has gazili role
            if (!$this->user->isStudent()) {
                $this->user->assignRole(['student']);
            }
        }

        if ($this->user->isStudent()) {
            $msg = "E-posta adresiniz doğrulandı. Artık bir fakülteye katılabilirsiniz.";
        } else {
            $msg = "E-posta adresiniz doğrulandı.";
        }

        // Update user's last activity
        $this->user->heartbeat();

        return redirect(route('home'))->success($msg);
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
