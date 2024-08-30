<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('E-posta Adresinizi Doğrulayın')]
class Verify extends Component
{

    use LivewireAlert;

    #[Layout('layout.auth')]

    protected User $user;

    public function mount()
    {
        $this->returnHomeIfVerified();
    }

    public function verifyUser(EmailVerificationRequest $request){
        $request->fulfill();

        return redirect(route('home'));
    }

    public function sendVerifyMail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        $this->alert('success', 'Doğrulama e-postası gönderildi.');

        return back();
    }

    protected function returnHomeIfVerified()
    {
        $this->user = Auth::user();
        // If user is verified, redirect to home page
        if ($this->user->hasVerifiedEmail()) {
            return redirect(route('home'));
        }
    }

    public function render()
    {
        return view('livewire.pages.auth.verify');
    }
}
