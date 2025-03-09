<?php

namespace App\Events\ZalimKasaba;

use App\Enums\ZalimKasaba\GameState;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class GameStateUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public int $lobbyId, public GameState $state)
    {
        $this->lobbyId = $lobbyId;
        $this->state = $state;
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
        return 'game.state.updated';
    }
}
