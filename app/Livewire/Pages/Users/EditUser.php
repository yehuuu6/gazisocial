<?php

namespace App\Livewire\Pages\Users;

use App\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;

class EditUser extends Component
{

    use LivewireAlert;

    public User $user;

    // Profile Info
    public $name;
    public $username;
    public $bio;

    // Update Password
    public $currentPassword;
    public $newPassword;

    // Update Account Privacy Settings
    public $profileVisibility;
    public $badgeVisibility; // default, partial, hidden

    public function mount(User $user)
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->username = $user->username;
        $this->bio = $user->bio;
        $this->profileVisibility = $user->is_private ? 'private' : 'public';
        $this->badgeVisibility = $user->badge_visibility;

        $this->authorize('view', $this->user);
    }

    public function updateProfileInfo() {}

    public function updatePassword() {}

    public function updatePrivacyInfo()
    {

        $this->authorize('update', $this->user);

        try {
            $this->validate([
                'profileVisibility' => 'required|in:public,private',
                'badgeVisibility' => 'required|in:default,partial,hidden',
            ]);
        } catch (ValidationException $e) {
            $this->alert('error', $e->getMessage());
        }

        // If there is no change in the privacy settings, return
        if ($this->profileVisibility === ($this->user->is_private ? 'private' : 'public') && $this->badgeVisibility === $this->user->badge_visibility) {
            $this->alert('info', 'Değişiklik yapmadınız.');
            return;
        }

        $result = $this->user->update([
            'is_private' => $this->profileVisibility === 'private' ? 1 : 0,
            'badge_visibility' => $this->badgeVisibility,
        ]);

        if ($result) {
            $this->alert('success', 'Tercihler başarıyla kaydedildi.');
        } else {
            $this->alert('error', 'Tercihler kaydedilirken bir hata oluştu.');
        }
    }

    public function render()
    {
        return view('livewire.pages.users.edit-user');
    }
}
