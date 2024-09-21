<?php

namespace App\Livewire\Modals;

use Livewire\Component;
use App\Models\User;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;

class UpdateAvatarModal extends Component
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

        // Clear the avatar property
        $this->avatar = null;

        // Clear temporary avatar files
        $this->reset('avatar');

        // Dispatch the modal close event
        $this->dispatch('avatar-updated');
    }

    public function updateAvatar()
    {

        // Validate the image

        $messages = [
            'avatar.required' => 'Geçerli bir dosya yükleyin.',
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

        // Clear the avatar property
        $this->avatar = null;

        // Clear temporary avatar files
        $this->reset('avatar');

        // Dispatch the modal close event
        $this->dispatch('avatar-updated');
    }

    public function render()
    {
        return view('livewire.modals.update-avatar-modal');
    }
}
