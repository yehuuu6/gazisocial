<?php

namespace App\Traits\ZalimKasaba;

use App\Enums\ZalimKasaba\ChatMessageType;
use App\Enums\ZalimKasaba\GameState;
use App\Enums\ZalimKasaba\PlayerRole;
use App\Events\ZalimKasaba\GameStateUpdated;
use Illuminate\Support\Collection;
use Masmerise\Toaster\Toaster;

trait StateManager
{
    use StateEnterEvents, StateExitEvents;

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

        // In seconds
        $timerValues = [
            GameState::PREPARATION->value => 15,
            GameState::DAY->value => $currentDay === 0 ? 20 : 45,
            GameState::VOTING->value => 30,
            GameState::DEFENSE->value => 20,
            GameState::JUDGMENT->value => 20,
            GameState::LAST_WORDS->value => 10,
            GameState::NIGHT->value => 40,
            GameState::REVEAL->value => 15,
            GameState::GAME_OVER->value => 20
        ];

        // If the next state is in the timerValues array, set the countdown_end
        if (array_key_exists($nextState->value, $timerValues)) {
            $this->lobby->update(['countdown_start' => now(), 'countdown_end' => now()->addSeconds($timerValues[$nextState->value])]);
        }

        $this->runStateEnterEvents($nextState);

        // Broadcast the updated state to all users in the lobby.
        broadcast(new GameStateUpdated($this->lobby->id, $nextState));
    }

    private function checkGameOver(): void
    {
        $lobby = $this->lobby;

        // Townies win condition
        // If there are no alive mafia members, townies win
        // Check PlayerRole::getMafiaRoles() array using where('role.enum')
        $mafiaRoles = $lobby->players->filter(function ($player) {
            return in_array($player->role->enum, PlayerRole::getMafiaRoles()) && $player->is_alive;
        });

        $townRoles = $lobby->players->filter(function ($player) {
            return in_array($player->role->enum, PlayerRole::getTownRoles()) && $player->is_alive;
        });

        $winnerUsernameArray = $this->calculateConditionalWins($mafiaRoles, $townRoles);

        if ($mafiaRoles->isEmpty() && !$townRoles->isEmpty()) {
            // Merge the winnerUsernameArray with the townRoles
            $winnerUsernameArray = array_merge($winnerUsernameArray, $townRoles->map(fn($player) => $player->user->username)->toArray());
            $this->sendSystemMessage('Kasaba kazandı! Kazananlar: ' . implode(', ', $winnerUsernameArray), type: ChatMessageType::SUCCESS);
            $lobby->update(['state' => GameState::GAME_OVER]);
            return;
        }
        if ($townRoles->isEmpty() && !$mafiaRoles->isEmpty()) {
            // Merge the winnerUsernameArray with the mafiaRoles
            $winnerUsernameArray = array_merge($winnerUsernameArray, $mafiaRoles->map(fn($player) => $player->user->username)->toArray());
            $this->sendSystemMessage('Mafya kazandı! Kazananlar: ' . implode(', ', $winnerUsernameArray), type: ChatMessageType::SUCCESS);
            $lobby->update(['state' => GameState::GAME_OVER]);
            return;
        }
    }

    private function calculateConditionalWins(Collection $mafiaRoles, Collection $townRoles): array
    {
        $winnerUsernameArray = [];
        // Jester win condition
        $jesterPlayers = $this->lobby->players->where('role.enum', PlayerRole::JESTER)
            ->where('is_alive', false)
            ->where('can_haunt', true);

        foreach ($jesterPlayers as $jesterPlayer) {
            $winnerUsernameArray[] = $jesterPlayer->user->username;
        }

        // Witch win condition
        $witchPlayer = $this->lobby->players->where('role.enum', PlayerRole::WITCH)->where('is_alive', true)->first();
        if ($witchPlayer && $townRoles->isEmpty()) {
            $winnerUsernameArray[] = $witchPlayer->user->username;
        }

        // Angel win condition
        $angelPlayers = $this->lobby->players->where('role.enum', PlayerRole::ANGEL)->where('is_alive', true);
        foreach ($angelPlayers as $angelPlayer) {
            $winnerUsernameArray[] = $angelPlayer->user->username;
        }

        return $winnerUsernameArray;
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
        };
    }
}
