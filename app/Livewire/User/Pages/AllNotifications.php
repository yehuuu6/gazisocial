<?php

namespace App\Livewire\User\Pages;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Masmerise\Toaster\Toaster;

class AllNotifications extends Component
{
    use WithPagination;

    public function markAllAsRead()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $user->notifications()->update(['read' => true]);
        $this->dispatch('notification-updated');
    }

    public function deleteNotification(int $notificationId)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $notificationId)->first();

        if ($notification) {
            $notification->delete();
            Toaster::success('Bildirim başarıyla silindi.');
            $this->dispatch('notification-updated');
        }
    }

    public function deleteAllNotifications()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $user->notifications()->delete();
        Toaster::success('Tüm bildirimler başarıyla silindi.');
        $this->dispatch('notification-updated');
    }

    public function markAsRead(int $notificationId, bool $goToAction = true)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $notificationId)->first();
        if ($notification && !$notification->read) {
            $notification->update(['read' => true]);
        }

        $this->dispatch('notification-updated');

        // Redirect to the notification's action
        if ($goToAction && ($notification->type == 'post_comment' || $notification->type == 'comment_reply') && isset($notification->data['action_url'])) {
            return $this->redirect($notification->data['action_url'], navigate: true);
        }
    }

    #[Computed]
    public function notifications()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        return $user->notifications()->latest()->paginate(20);
    }

    public function getNotificationTitle(string $notificationType)
    {
        switch ($notificationType) {
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
        return view('livewire.user.pages.all-notifications')
            ->title('Bildirimlerim - ' . config('app.name'));
    }
}
