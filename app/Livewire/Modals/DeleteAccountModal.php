<?php

namespace App\Livewire\Modals;

use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DeleteAccountModal extends Component
{

    use LivewireAlert;

    public $email;
    public $password;
    public $confirm;

    public function deleteAccount()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
            'confirm' => 'required',
        ]);

        if ($this->confirm !== 'DELETE') {
            $this->alert('error', 'Lütfen "DELETE" yazarak hesabınızı silmeyi onaylayın.');
            return;
        }

        $user = Auth::user();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->alert('error', 'E-posta adresi veya şifre hatalı.');
            return;
        }

        /**
         * @var \App\Models\User $user
         */
        $user->delete();

        $this->flash('success', 'Hesabınız başarıyla silindi.');
    }

    public function render()
    {
        return view('livewire.modals.delete-account-modal');
    }
}
