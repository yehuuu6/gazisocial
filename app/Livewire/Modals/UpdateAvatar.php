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

    public function save()
    {
        $messages = [
            'avatar.required' => 'Bir avatar yüklemelisiniz!',
            'avatar.image' => 'Avatar resim dosyası olmalıdır.',
            'avatar.max' => 'Avatar en fazla 1 MB boyutunda olabilir.',
        ];

        try {
            $this->validate([
                'avatar' => 'required|image|max:1024',
            ], $messages);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $errorMessage = implode('<br>', $errors);
            $this->alert('error', $errorMessage);
            return;
        }

        // Kullanıcının mevcut avatarını al
        $this->user = Auth::user();
        $oldAvatar = $this->user->avatar;

        // Yeni avatarı depola ve dosya adını al
        $avatarPath = $this->avatar->store('avatars');

        // Eğer eski bir avatar varsa ve varsayılan avatar değilse sil
        if ($oldAvatar && Storage::exists(ltrim($oldAvatar, '/'))) {
            Storage::delete(ltrim($oldAvatar, '/'));
        }

        // Kullanıcının avatarını veritabanında güncelle
        $this->user->avatar = "/" . $avatarPath;
        $this->user->save();

        $this->alert('success', 'Fotoğrafınız güncellendi!');

        // Refresh Auth::user

        $this->user->refresh();

        $this->dispatch('closeModal');
    }



    public function render()
    {
        return view('livewire.modals.update-avatar');
    }
}
