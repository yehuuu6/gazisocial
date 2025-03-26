<?php

namespace App\Traits\ZalimKasaba;

use App\Models\ZalimKasaba\Lobby;
use App\Models\ZalimKasaba\Player;
use Illuminate\Support\Facades\Auth;
use App\Enums\ZalimKasaba\LobbyStatus;
use App\Events\ZalimKasaba\KickPlayerEvent;

trait PlayerManager
{
    /**
     * Initializes current player instance
     * @return Player
     */
    private function initializeCurrentPlayer(): Player
    {
        $currentPlayer = $this->lobby->players()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'is_online' => true,
                'is_host' => $this->lobby->host_id === Auth::id(),
            ],
        );

        return $currentPlayer;
    }

    public function handleKick($payload)
    {
        if ($payload['playerId'] === $this->currentPlayer->id) {
            return redirect()->route('games.zk.lobbies')->warning('Yönetici tarafından oyundan atıldınız.');
        }

        if (!$this->currentPlayer->is_host) return;

        $player = $this->lobby->players()->find($payload['playerId']);

        if ($player) {
            $player->delete();
        }

        $this->reorderPlayerPlaces($this->lobby);
    }

    public function kickPlayer(Player $player)
    {
        if (!$this->currentPlayer->is_host) return;
        broadcast(new KickPlayerEvent($this->lobby->id, $player->id));
        if (!$player->is_online) {
            $player->delete();
        }
        $this->sendSystemMessage($player->user->username . ' yönetici tarafından oyundan atıldı.');
    }

    /**
     * Reorders the player places in the lobby
     * @param Lobby $lobby
     */
    private function reorderPlayerPlaces(Lobby $lobby)
    {
        $players = $lobby->players()->oldest()->get();
        $place = 1;

        foreach ($players as $player) {
            if ($player->place !== $place) {
                $player->update(['place' => $place]);
            }
            $place++;
        }
    }

    /**
     * Randomizes the place values of all players in the lobby.
     * @return void
     */
    private function randomizePlayerPlaces()
    {
        // Get all players in the lobby
        $players = $this->lobby->players()->get();

        // Shuffle the players collection
        $shuffledPlayers = $players->shuffle();

        // Assign new place values starting from 1
        $place = 1;
        foreach ($shuffledPlayers as $player) {
            $player->update(['place' => $place]);
            $place++;
        }
    }

    private function getPlayerById(int $userId): Player | null
    {
        return $this->lobby->players()->where('user_id', $userId)->first();
    }

    public function handleUsersHere($users)
    {
        $offlinePlayerIds = $this->lobby->players()
            ->whereNotIn('user_id', collect($users)->pluck('id'))
            ->pluck('id');

        if ($offlinePlayerIds->isNotEmpty()) {
            $this->lobby->players()->whereIn('id', $offlinePlayerIds)->update([
                'is_online' => false,
            ]);
        }

        // Grab the host player
        $hostId = collect($users)->first(fn($user) => $user['id'] === $this->lobby->host_id);

        if (!$hostId) {
            $this->lobby->update(['status' => 'waiting_host']);
            //return redirect()->route('games.zk.lobbies')->warning('Oyun yöneticisi aktif değil.');
        } else {
            $this->lobby->update(['status' => 'active']);
        }
    }

    public function handleUserJoined($user)
    {
        $player = $this->getPlayerById($user['id']);

        if ($player->is_host) {
            $this->lobby->update(['status' => 'active']);
            $this->dispatch('host-returned');
        }

        if ($player && !$player->is_online) {
            $player->update([
                'is_online' => true,
            ]);
        }
    }

    public function handleUserLeft($user)
    {
        $player = $this->getPlayerById($user['id']);

        if ($player && $player->is_online) {
            $player->update([
                'is_online' => false,
            ]);

            if ($player->is_host && $this->lobby->status !== LobbyStatus::WAITING_HOST) {
                $this->lobby->update(['status' => 'waiting_host']);
                $this->dispatch('host-left');
            }
        }
    }
}
