<?php

namespace App\Livewire\User\Pages;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

#[Title('Hesap ayarları - Gazi Social')]
class EditUser extends Component
{
    use WithFileUploads;

    public User $user;

    // Profile Info
    public $name;
    public $username;
    public $bio;

    public $avatar;

    // Update Password
    public $current_password;
    public $password;
    public $password_confirmation;

    public $gender;

    public bool $deleteAccountModal = false;

    // Delete Account
    public $deleteAccountConfirmation;

    public function mount(User $user)
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->username = $user->username;
        $this->bio = $user->bio;

        $this->gender = $user->gender;

        $this->authorize('view', $this->user);
    }

    public function deleteAvatar()
    {
        if (!$this->user->avatar) {
            Toaster::error('Avatar resmi bulunamadı.');
            return;
        }

        $this->authorize('update', $this->user);

        $oldAvatar = $this->user->avatar;

        // Delete the old avatar if it exists and is not the default
        if ($oldAvatar && Storage::exists($oldAvatar)) {
            Storage::delete($oldAvatar);
        } else {
            Toaster::error('Avatar resmi bulunamadı.');
            return;
        }

        // Alert success message
        Toaster::success('Avatar resminiz başarıyla silindi.');

        // Update the user's avatar in the database
        $this->user->update([
            'avatar' => null,
        ]);

        // Clear temporary avatar files
        $this->reset('avatar');
    }

    public function saveAvatar()
    {
        $messages = [
            'avatar.image' => 'Avatar resmi bir resim dosyası olmalıdır.',
            'avatar.max' => 'Avatar resmi en fazla 2 MB olabilir.',
            'avatar.mimes' => 'Avatar resmi sadece :values formatında olabilir.',
        ];

        try {
            $this->validate([
                'avatar' => 'image|max:2048|mimes:jpeg,png,jpg,webp',
            ], $messages);
        } catch (ValidationException $e) {
            Toaster::error($e->getMessage());
            return;
        }

        $oldAvatar = $this->user->avatar;

        // Store the new avatar and get its path
        $avatarPath = '/' . $this->avatar->store('avatars');

        // Delete the old avatar if it exists and is not the default
        if ($oldAvatar && Storage::exists($oldAvatar)) {
            Storage::delete($oldAvatar);
        }

        // Update the user's avatar in the database
        $this->user->update([
            'avatar' => $avatarPath,
        ]);

        // Alert success message
        Toaster::success('Avatar resminiz güncellendi.');

        // Clear temporary avatar files
        $this->reset('avatar');
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

        if ($this->bio === '') {
            $this->bio = "Herhangi bir bilgi verilmedi.";
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

    public function updateGender()
    {
        $this->authorize('update', $this->user);

        $this->user->update([
            'gender' => $this->gender,
        ]);

        Toaster::success('Cinsiyet bilginiz başarıyla güncellendi.');
    }

    public function deleteAccount()
    {
        $this->authorize('delete', $this->user);

        if ($this->deleteAccountConfirmation !== 'ONAYLA') {
            Toaster::error('Hesabınızı silmek için "ONAYLA" yazın.');
            return;
        }

        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        if ($user->id !== $this->user->id) {
            Toaster::error('Sadece kendi hesabınızı silebilirsiniz.');
            return;
        }

        // Kullanıcının avatarını silme
        if ($user->avatar && Storage::exists($user->avatar)) {
            Storage::delete($user->avatar);
        }

        // Kullanıcının ilişkili diğer verileri silmek için gerekli işlemler burada yapılabilir
        // Not: cascade=true ile tanımlanan ilişkilerin otomatik silinmesi mümkündür

        // Hesabı silme
        $user->delete();

        // Oturumu sonlandırma
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // Giriş sayfasına yönlendirme
        return redirect()->route('login')->with('success', 'Hesabınız başarıyla silindi.');
    }

    public function render()
    {
        return view('livewire.user.pages.edit-user');
    }
}
