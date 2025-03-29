<?php

namespace App\Console\Commands;

use App\Models\ZalimKasaba\Lobby;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupInactiveLobbies extends Command
{
    protected $signature = 'lobbies:cleanup';
    protected $description = 'Remove inactive lobbies that have been inactive for more than 5 minutes';

    public function handle()
    {
        $this->info('Starting cleanup of inactive lobbies...');

        $inactiveThreshold = Carbon::now()->subMinutes(5);

        $inactiveLobbies = Lobby::where('countdown_end', '<', $inactiveThreshold)->get();

        $notStartedOldLobbies = Lobby::where('state', 'lobby')
            ->where('created_at', '<', $inactiveThreshold)
            ->get();

        $inactiveLobbies = $inactiveLobbies->merge($notStartedOldLobbies);

        $count = $inactiveLobbies->count();

        if ($count === 0) {
            return;
        }

        foreach ($inactiveLobbies as $lobby) {
            $lobby->delete();
        }

        $this->info("Cleanup completed. Removed {$count} inactive lobbies.");
    }
}
