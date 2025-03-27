<?php

namespace App\Events;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $receiver;

    public $queue = 'notifications';

    /**
     * Create a new event instance.
     * @param Notification $notification
     * @param User $receiver the user who will receive the notification
     * @param User $sender the user who replied to the comment
     */
    public function __construct(User $receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel("notifications.{$this->receiver->id}");
    }
}
