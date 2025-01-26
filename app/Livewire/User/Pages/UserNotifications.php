<?php

namespace App\Livewire\User\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class UserNotifications extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Computed]
    public function notifications()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        return $user->notifications()->latest()->simplePaginate(10);
    }

    public function getNotificationTitle(string $notificationType)
    {
        switch ($notificationType) {
            case 'friend_request':
                return 'Arkadaşlık isteği';
            case 'friend_accept':
                return 'Artık arkadaşsınız';
            case 'post_comment':
                return 'Yeni yorum';
            case 'comment_reply':
                return 'Yeni yanıt';
            default:
                return 'Bilinmeyen bildirim';
        }
    }

    public function render()
    {
        return view('livewire.user.pages.user-notifications');
    }
}
