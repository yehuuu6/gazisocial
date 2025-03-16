<?php

namespace App\Livewire\User;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Masmerise\Toaster\Toaster;

class NotificationLister extends Component
{

    public bool $hasUnreadNotifications;

    public function mount()
    {
        $this->setUnreadBool();
    }

    private function setUnreadBool(): void
    {
        Notification::where('user_id', Auth::id())->where('read', false)->exists()
            ? $this->hasUnreadNotifications = true
            : $this->hasUnreadNotifications = false;
    }

    public function placeholder()
    {
        return view('components.placeholders.generic-spinner', [
            'size' => 33,
            'class' => 'text-primary'
        ]);
    }

    public function markAllAsRead()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $user->notifications()->update(['read' => true]);
        $this->hasUnreadNotifications = false;
    }

    public function markAsRead(int $notificationId)
    {

        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $notificationId)->first();
        if ($notification && !$notification->read) {
            $notification->update(['read' => true]);
        }

        // If there are no unread notifications, set the flag to false
        $this->setUnreadBool();

        // Redirect to the notification's action

        if (($notification->type == 'post_comment' || $notification->type == 'comment_reply') && isset($notification->data['action_url'])) {
            return $this->redirect($notification->data['action_url'], navigate: true);
        }
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
            $this->setUnreadBool();
        }
    }

    #[Computed]
    public function notifications()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        return $user->notifications()->latest()->limit(10)->get();
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

    public function getListeners(): array
    {
        $userId = Auth::id();
        return [
            "echo-private:notifications.{$userId},NotificationReceived" => 'refresh',
        ];
    }

    public function render()
    {
        $this->setUnreadBool();

        return view('livewire.user.notification-lister');
    }
}
