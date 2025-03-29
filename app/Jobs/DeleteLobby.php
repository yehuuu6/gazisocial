<?php

namespace App\Jobs;

use App\Models\ZalimKasaba\Lobby;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use function React\Promise\Timer\sleep;

class DeleteLobby implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $lobbyId)
    {
        // Initialize the job with the lobby ID
        $this->lobbyId = $lobbyId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Delete the lobby after 5 seconds
        sleep(5);
        $lobby = Lobby::find($this->lobbyId);
        if ($lobby) {
            $lobby->delete();
        }
    }
}
