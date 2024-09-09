<?php

namespace App\Livewire\Modals;

use App\Models\User;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;

class UpdateAvatar extends ModalComponent
{

    use LivewireAlert, WithFileUploads;

    public $avatar;

    protected User $user;

    public function removeAvatar()
    {

        // Retrieve the current user
        $this->user = Auth::user();
        $oldAvatar = $this->user->avatar;

        // Delete the old avatar if it exists and is not the default
        if ($oldAvatar && Storage::exists($oldAvatar)) {
            Storage::delete($oldAvatar);
        } else {
            $this->alert('error', 'Fotoğrafınız zaten kaldırılmış!');
            return;
        }

        // Update the user's avatar in the database
        $this->user->avatar = 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name) . '&background=random';
        $this->user->save();

        // Alert success message
        $this->alert('success', 'Fotoğrafınız kaldırıldı!');

        // Refresh the user instance
        $this->user->refresh();

        // Dispatch the modal close event
        $this->dispatch('closeModal');
    }

    public function updateAvatar()
    {

        // Validate the image

        $messages = [
            'avatar.required' => 'Fotoğraf alanı boş bırakılamaz.',
            'avatar.image' => 'Yüklenen dosya bir resim olmalıdır.',
            'avatar.max' => 'Fotoğrafın boyutu 1MB\'ı geçemez.',
        ];

        try {
            $this->validate([
                'avatar' => 'required|image|max:1024',
            ], $messages);
        } catch (ValidationException $e) {
            $this->alert('error', $e->getMessage());
            return;
        }

        // Retrieve the current user
        $this->user = Auth::user();
        $oldAvatar = $this->user->avatar;

        // Store the new avatar and get its path
        $avatarPath = '/' . $this->avatar->store('avatars');

        // Delete the old avatar if it exists and is not the default
        if ($oldAvatar && Storage::exists($oldAvatar)) {
            Storage::delete($oldAvatar);
        }

        // Update the user's avatar in the database
        $this->user->avatar = $avatarPath;
        $this->user->save();

        // Alert success message
        $this->alert('success', 'Fotoğrafınız güncellendi!');

        // Refresh the user instance
        $this->user->refresh();

        // Dispatch the modal close event
        $this->dispatch('closeModal');
    }



    public function render()
    {
        return view('livewire.modals.update-avatar');
    }
}
