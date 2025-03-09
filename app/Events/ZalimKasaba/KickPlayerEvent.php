<?php

namespace App\Events\ZalimKasaba;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KickPlayerEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public int $lobbyId, public int $playerId)
    {
        $this->lobbyId = $lobbyId;
        $this->playerId = $playerId;
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
        return 'game.player.kicked';
    }
}
