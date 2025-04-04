<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PollVoted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $queue = 'notifications';

    /**
     * Create a new event instance.
     */
    public function __construct(public readonly int $postId) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('polls.' . $this->postId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'poll.voted';
    }
}
