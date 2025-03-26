<?php

namespace App\Livewire\ZalimKasaba;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\ZalimKasaba\Lobby;
use App\Models\ZalimKasaba\Player;
use App\Enums\ZalimKasaba\GameState;
use Illuminate\Support\Facades\Auth;
use App\Enums\ZalimKasaba\LobbyStatus;
use App\Traits\ZalimKasaba\ChatManager;
use App\Traits\ZalimKasaba\VoteManager;
use App\Traits\ZalimKasaba\StateManager;
use App\Traits\ZalimKasaba\PlayerManager;
use App\Traits\ZalimKasaba\PlayerActionsManager;
use Illuminate\Support\Collection;
use Masmerise\Toaster\Toaster;

class ShowLobby extends Component
{
    // Resolve method name conflicts using trait aliasing
    use StateManager {
        StateManager::calculateRequiredVotes as calculateVoteThreshold;
    }
    use ChatManager, PlayerManager, VoteManager, PlayerActionsManager;

    public Lobby $lobby;

    public string $gameTitle = '';

    public Player $currentPlayer;
    public ?Player $hostPlayer;

    public Collection $deadPlayers;

    public bool $judgeModal;
    public bool $showLastWill = false;
    public bool $showPlayerLastWill = false;

    public function mount(Lobby $lobby)
    {
        $this->lobby = $lobby;

        if ($lobby->status === LobbyStatus::WAITING_HOST && $lobby->host_id !== Auth::id()) {
            //return redirect()->route('games.zk.lobbies')->warning('Oyun yöneticisi aktif değil.');
        }

        $this->gameTitle = $this->setGameTitle($lobby);

        $this->currentPlayer = $this->initializeCurrentPlayer();

        $this->hostPlayer = $lobby->players()->where('is_host', true)->first();

        $this->checkHostAvailability();

        if ($this->currentPlayer->wasRecentlyCreated) {
            $this->currentPlayer->update(['place' => $this->lobby->players()->max('place') + 1]);
            $this->sendSystemMessage($this->currentPlayer->user->username . ' oyuna katıldı.');
        }

        $this->setJudgeModalState();

        $this->deadPlayers = $this->lobby->players()->where('is_alive', false)->get();
    }

    private function checkHostAvailability()
    {
        if (!$this->hostPlayer) {
            //return redirect()->route('games.zk.lobbies')->warning('Oyun yöneticisi aktif değil.');
        }
    }

    private function assignRoles(Lobby $lobby)
    {
        $players = $lobby->players;

        $availableRoles = $lobby->roles->shuffle();

        // Assign roles to players
        foreach ($players as $player) {
            $role = $availableRoles->pop();
            $player->update([
                'game_role_id' => $role->id,
                'ability_uses' => $role->ability_limit,
            ]);
        }
    }

    /**
     * Sets the game title based on the lobby state
     * @return string
     */
    private function setGameTitle(): string
    {
        return match ($this->lobby->state) {
            GameState::LOBBY => '🏟️ Lobi',
            GameState::PREPARATION => '🎲 Hazırlık',
            GameState::DAY => "🌞 {$this->lobby->day_count}. Gün",
            GameState::VOTING => '🗳️ Oylama',
            GameState::DEFENSE => '🛡️ Savunma',
            GameState::JUDGMENT => "⚖️ Yargı ({$this->lobby->accused?->user->username})",
            GameState::LAST_WORDS => '🗣️ Son Sözler',
            GameState::NIGHT => "🌙 {$this->lobby->day_count}. Gece",
            GameState::REVEAL => '🔍 Açıklama',
            GameState::GAME_OVER => '🏁 Oyun Bitti',
        };
    }

    public function getListeners()
    {
        return [
            "echo-presence:zalim-kasaba-lobby.{$this->lobby->id},.game.state.updated" => 'handleGameStateUpdated',
            "echo-presence:zalim-kasaba-lobby.{$this->lobby->id},.game.player.kicked" => 'handleKick',
            "echo-presence:zalim-kasaba-lobby.{$this->lobby->id},.game.player.voted" => 'handleVote',
            "echo-presence:zalim-kasaba-lobby.{$this->lobby->id},here" => 'handleUsersHere',
            "echo-presence:zalim-kasaba-lobby.{$this->lobby->id},joining" => 'handleUserJoined',
            "echo-presence:zalim-kasaba-lobby.{$this->lobby->id},leaving" => 'handleUserLeft',
        ];
    }

    public function handleVote($payload)
    {
        // Refresh players list
        $this->lobby->players()->orderBy('place')->get();

        if ($this->currentPlayer->is_host && $this->lobby->state === GameState::VOTING) {
            $this->checkEnoughVotes();
        }
    }

    public function handleGameStateUpdated($payload)
    {
        $this->setJudgeModalState();
        $this->gameTitle = $this->setGameTitle($this->lobby);
        $this->deadPlayers = $this->lobby->players()->where('is_alive', false)->get();
    }

    public function startGame()
    {
        if ($this->lobby->state !== GameState::LOBBY || !$this->currentPlayer->is_host || $this->lobby->status !== LobbyStatus::ACTIVE) {
            return;
        }

        if ($this->lobby->players->count() < $this->lobby->max_players) {
            Toaster::error('Oyuncu sayısı yetersiz. Oyuna başlamak için ' . $this->lobby->max_players . ' oyuncu gereklidir.');
            return;
        }

        $this->randomizePlayerPlaces();

        $this->nextState();
    }

    public function goToNextGameState()
    {
        if (!$this->currentPlayer->is_host) {
            return;
        }

        $this->runStateExitEvents($this->lobby->state);

        // If lobby countdown_end is still in the future, do not proceed
        // This is a protection against front-end manipulation
        if ($this->lobby->countdown_end && $this->lobby->countdown_end->isFuture()) {
            return;
        }

        $this->nextState();
    }

    public function toggleListing()
    {
        if (!$this->currentPlayer->is_host) {
            return;
        }

        $this->lobby->update([
            'is_listed' => !$this->lobby->is_listed
        ]);

        Toaster::success($this->lobby->is_listed ? 'Lobi listelendi.' : 'Lobi gizlendi.');
    }

    #[Layout('layout.games')]
    public function render()
    {
        if (!$this->currentPlayer->is_online) {
            $this->currentPlayer->update(['is_online' => true]);
        }
        return view('livewire.zalim-kasaba.show-lobby')->title($this->lobby->name . ' - Zalim Kasaba');
    }
}
