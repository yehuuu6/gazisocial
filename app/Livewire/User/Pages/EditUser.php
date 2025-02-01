<?php

namespace App\Livewire\User\Pages;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Masmerise\Toaster\Toaster;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toast;

#[Title('Hesap ayarları - Gazi Social')]
class EditUser extends Component
{
    public User $user;

    // Profile Info
    public $name;
    public $username;
    public $bio;

    // Update Password
    public $current_password;
    public $password;
    public $password_confirmation;

    // Update Account Privacy Settings
    public $profileVisibility;

    public function mount(User $user)
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->username = $user->username;
        $this->bio = $user->bio;

        $this->profileVisibility = $user->is_private ? 'private' : 'public';

        $this->authorize('view', $this->user);
    }

    public function leaveFaculty()
    {
        $user = Auth::user();

        if (!$user->faculty) {
            Toaster::error('Zaten bir fakülteye kayıtlı değilsiniz.');
            return;
        }

        /**
         * @var \App\Models\User $user
         */
        $user->faculty()->dissociate();
        $user->save();
        Toaster::success('Fakülte kaydınız başarıyla silindi.');
    }

    public function updateProfileInfo()
    {
        $this->authorize('update', $this->user);

        $messages = [
            'name.required' => 'Ad alanı boş bırakılamaz.',
            'name.string' => 'Ad alanı metin tipinde olmalıdır.',
            'name.max' => 'Ad alanı en fazla :max karakter olabilir.',
            'username.required' => 'Kullanıcı adı alanı boş bırakılamaz.',
            'username.string' => 'Kullanıcı adı alanı metin tipinde olmalıdır.',
            'username.max' => 'Kullanıcı adı alanı en fazla :max karakter olabilir.',
            'username.unique' => 'Bu kullanıcı adı zaten alınmış.',
            'bio.max' => 'Biyografi en fazla :max karakter olabilir.',
        ];

        try {
            $this->validate([
                'name' => 'required|string|max:30',
                'username' => 'required|string|max:30|unique:users,username,' . $this->user->id,
                'bio' => 'max:255',
            ], $messages);
        } catch (ValidationException $e) {
            Toaster::error($e->getMessage());
            return;
        }

        $result = $this->user->update([
            'name' => $this->name,
            'username' => $this->username,
            'bio' => $this->bio,
        ]);

        // If name is updated, update the avatar
        if ($result && $this->user->wasChanged('name')) {
            return redirect()->route('users.edit', $this->user->username)->success('Profil bilgileriniz başarıyla güncellendi.');
        }

        // If the username is updated, update the page URL
        if ($result && $this->user->wasChanged('username')) {
            return redirect()->route('users.edit', $this->username)->success('Profil bilgileriniz başarıyla güncellendi.');
            return;
        }

        if ($result) {
            Toaster::success('Profil bilgileriniz başarıyla güncellendi.');
        } else {
            Toaster::error('Profil bilgileriniz güncellenirken bir hata oluştu.');
        }
    }

    public function updatePassword()
    {
        $this->authorize('update', $this->user);

        $messages = [
            'current_password.required' => 'Mevcut şifrenizi girmelisiniz.',
            'password.required' => 'Yeni şifrenizi girmelisiniz.',
            'password.min' => 'Yeni şifreniz en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Şifreler uyuşmuyor.',
        ];

        try {
            $this->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ], $messages);
        } catch (ValidationException $e) {
            Toaster::error($e->getMessage());
            return;
        }

        if (!Hash::check($this->current_password, $this->user->password)) {
            Toaster::error('Mevcut şifrenizi yanlış girdiniz.');
            return;
        }

        $result = $this->user->update([
            'password' => Hash::make($this->password),
        ]);

        if ($result) {
            return Redirect::route('users.edit', $this->user->username)->success('Şifreniz başarıyla güncellendi.');
        } else {
            Toaster::error('Şifreniz güncellenirken bir hata oluştu.');
        }

        $this->reset();
    }

    public function updatePrivacyInfo()
    {

        $this->authorize('update', $this->user);

        try {
            $this->validate([
                'profileVisibility' => 'required|in:public,private',
            ]);
        } catch (ValidationException $e) {
            Toaster::error($e->getMessage());
            return;
        }

        // If there is no change in the privacy settings, return
        if ($this->profileVisibility === ($this->user->is_private ? 'private' : 'public')) {
            Toaster::warning('Değişiklik yapmadınız.');
            return;
        }

        $result = $this->user->update([
            'is_private' => $this->profileVisibility === 'private' ? 1 : 0,
        ]);

        if ($result) {
            Toaster::success('Tercihleriniz başarıyla kaydedildi.');
        } else {
            Toaster::error('Tercihler kaydedilirken bir hata oluştu.');
        }
    }

    public function render()
    {
        return view('livewire.user.pages.edit-user');
    }
}
