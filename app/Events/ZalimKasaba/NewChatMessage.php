<?php

namespace App\Events\ZalimKasaba;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lobbyId;
    public $msgId;

    /**
     * Create a new event instance.
     */
    public function __construct($lobbyId, $msgId)
    {
        $this->lobbyId = $lobbyId;
        $this->msgId = $msgId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('zalim-kasaba-lobby.' . $this->lobbyId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'game.new.message';
    }
}
