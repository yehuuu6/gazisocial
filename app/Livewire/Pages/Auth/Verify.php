<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
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

    public function verifyUser(EmailVerificationRequest $request)
    {

        $request->fulfill();
        $this->user = Auth::user();
        // if user has @gazi.edu.tr email, assign gazili role
        if (strpos($this->user->email, '@gazi.edu.tr') !== false) {
            // Check if user already has gazili role
            if ($this->user->roles()->where('name', 'öğrenci')->count() === 0) {
                $role = Role::find(1); // Gazili
                $this->user->roles()->attach($role);
            }
        }

        if ($this->user->isStudent()) {
            session()->flash('emailVerifiedStudent', 'E-posta adresiniz doğrulandı. Artık bir fakülteye katılabilirsiniz.');
            return redirect(route('faculties'));
        } else {
            session()->flash('emailVerified', 'E-posta adresiniz doğrulandı.');
            return redirect(route('home'));
        }
    }

    public function sendVerifyMail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        $this->alert('info', 'Doğrulama e-postası gönderildi.');
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
