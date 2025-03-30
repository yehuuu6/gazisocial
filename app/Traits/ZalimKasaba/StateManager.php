<?php

namespace App\Traits\ZalimKasaba;

use Illuminate\Support\Collection;
use App\Enums\ZalimKasaba\GameState;
use App\Enums\ZalimKasaba\PlayerRole;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Events\ZalimKasaba\GameStateUpdated;
use Masmerise\Toaster\Toaster;

trait StateManager
{
    use StateEnterEvents, StateExitEvents;

    /**
     * Calculate the required number of votes based on the number of alive players.
     * @return int
     */
    private function calculateRequiredVotes(): int
    {
        $alivePlayers = $this->lobby->players()->where('is_alive', true)->count();

        if ($alivePlayers >= 14) return 8;
        if ($alivePlayers >= 12) return 7;
        if ($alivePlayers >= 10) return 6;
        if ($alivePlayers >= 8) return 5;
        if ($alivePlayers >= 6) return 4;
        if ($alivePlayers >= 4) return 3;
        return 2; // For 2-3 players
    }

    /**
     * Changes the state of the lobby to the next state.
     * @param ?GameState $override If provided, the state will be set to this value.
     * @return void
     */
    private function nextState(?GameState $override = null): void
    {
        if ($this->lobby->state->isFinal()) return;

        // Determine the next state: use override if provided, otherwise use default next state
        $nextState = $override ?? $this->lobby->state->next();

        $currentDay = $this->lobby->day_count;

        if ($nextState === GameState::DAY) {
            $this->lobby->update(['day_count' => $currentDay + 1]);
        }

        $this->lobby->update(['state' => $nextState]);

        $timerValues = [
            GameState::PREPARATION->value => 15,
            GameState::DAY->value => $currentDay === 0 ? 10 : 45,
            GameState::VOTING->value => 30,
            GameState::DEFENSE->value => 20,
            GameState::JUDGMENT->value => 20,
            GameState::LAST_WORDS->value => 10,
            GameState::NIGHT->value => 45,
            GameState::REVEAL->value => 5,
            GameState::GAME_OVER->value => 30,
        ];

        // In seconds
        $testTimerValues = [
            GameState::PREPARATION->value => 15,
            GameState::DAY->value => $currentDay === 0 ? 10 : 10,
            GameState::VOTING->value => 10,
            GameState::DEFENSE->value => 10,
            GameState::JUDGMENT->value => 10,
            GameState::LAST_WORDS->value => 10,
            GameState::NIGHT->value => 10,
            GameState::REVEAL->value => 5,
            GameState::GAME_OVER->value => 10,
        ];

        // If the next state is in the timerValues array, set the countdown_end
        if (array_key_exists($nextState->value, $timerValues)) {
            $this->lobby->update(['countdown_start' => now(), 'countdown_end' => now()->addSeconds($timerValues[$nextState->value])]);
        }

        $this->runStateEnterEvents($nextState);

        // Broadcast the updated state to all users in the lobby.
        broadcast(new GameStateUpdated($this->lobby->id, $nextState));
    }

    public function checkGameOver(): void
    {
        $lobby = $this->lobby;
        $players = $lobby->players;

        // Get players by faction
        $mafiaPlayers = $players->filter(function ($player) {
            return in_array($player->role->enum, PlayerRole::getMafiaRoles());
        });

        $townPlayers = $players->filter(function ($player) {
            return in_array($player->role->enum, PlayerRole::getTownRoles());
        });

        $aliveTownPlayers = $townPlayers->where('is_alive', true);
        $aliveMafiaPlayers = $mafiaPlayers->where('is_alive', true);

        // Calculate winners including special roles
        $winners = $this->calculateWinners($aliveTownPlayers);

        // If there are no alive players, the game is over. Only the neutral or chaotic roles can win.
        if ($aliveTownPlayers->isEmpty() && $aliveMafiaPlayers->isEmpty()) {
            $this->sendSystemMessage('Oyun sona erdi. Kazananlar: ' . implode(', ', $winners), type: ChatMessageType::DEFAULT);
            $this->nextState(GameState::GAME_OVER);
            return;
        }

        // Check win conditions
        if ($aliveMafiaPlayers->isEmpty() && !$aliveTownPlayers->isEmpty()) {
            // Town wins
            $winners = array_merge($winners, $townPlayers->map(fn($player) => $player->user->username)->toArray());
            $this->sendSystemMessage('Kasaba kazandı! Kazananlar: ' . implode(', ', $winners), type: ChatMessageType::SUCCESS);
            $this->nextState(GameState::GAME_OVER);
            return;
        }

        if ($aliveTownPlayers->isEmpty() && !$aliveMafiaPlayers->isEmpty()) {
            // Mafia wins
            $winners = array_merge($winners, $mafiaPlayers->map(fn($player) => $player->user->username)->toArray());
            $this->sendSystemMessage('Mafya kazandı! Kazananlar: ' . implode(', ', $winners), type: ChatMessageType::WARNING);
            $this->nextState(GameState::GAME_OVER);
            return;
        }
    }

    /**
     * Calculate winners from special roles based on current game state
     * 
     * @param Collection $aliveTownPlayers
     * @return array Array of winner usernames
     */
    private function calculateWinners(Collection $aliveTownPlayers): array
    {
        $winners = [];
        $players = $this->lobby->players;

        // Jester win condition - successful haunting
        $winners = array_merge(
            $winners,
            $players->where('role.enum', PlayerRole::JESTER)
                ->where('is_alive', false)
                ->where('can_haunt', true)
                ->map(fn($player) => $player->user->username)
                ->toArray()
        );

        // Witch win condition - alive when town is eliminated
        if ($aliveTownPlayers->isEmpty()) {
            $witchPlayer = $players->where('role.enum', PlayerRole::WITCH)
                ->where('is_alive', true)
                ->first();

            if ($witchPlayer) {
                $winners[] = $witchPlayer->user->username;
            }
        }

        // Angel win condition - stayed alive
        $winners = array_merge(
            $winners,
            $players->where('role.enum', PlayerRole::ANGEL)
                ->where('is_alive', true)
                ->map(fn($player) => $player->user->username)
                ->toArray()
        );

        return $winners;
    }

    /**
     * Execute events before the next state is entered.
     * @param GameState $currentState
     * @return void
     */
    private function runStateExitEvents(GameState $currentState): void
    {
        match ($currentState) {
            GameState::LOBBY => $this->exitLobby(),
            GameState::DAY => $this->exitDay(),
            GameState::VOTING => $this->exitVoting(),
            GameState::DEFENSE => $this->exitDefense(),
            GameState::JUDGMENT => $this->exitJudgment(),
            GameState::LAST_WORDS => $this->exitLastWords(),
            GameState::NIGHT => $this->exitNight(),
            GameState::REVEAL => $this->exitReveal(),
            GameState::PREPARATION => $this->exitPreparation(),
            GameState::GAME_OVER => $this->exitGameOver(),
        };
    }

    /**
     * Execute events when the given state is entered.
     * @param GameState $nextState
     * @return void
     */
    private function runStateEnterEvents(GameState $nextState): void
    {
        match ($nextState) {
            GameState::DAY => $this->enterDay(),
            GameState::VOTING => $this->enterVoting(),
            GameState::DEFENSE => $this->enterDefense(),
            GameState::JUDGMENT => $this->enterJudgment(),
            GameState::LAST_WORDS => $this->enterLastWords(),
            GameState::NIGHT => $this->enterNight(),
            GameState::REVEAL => $this->enterReveal(),
            GameState::PREPARATION => $this->enterPreparation(),
            GameState::GAME_OVER => $this->enterGameOver(),
        };
    }
}
