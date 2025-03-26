<?php

namespace App\Traits\ZalimKasaba;

use App\Enums\ZalimKasaba\GameState;
use App\Events\ZalimKasaba\GameStateUpdated;

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

        // In seconds
        $timerValues = [
            GameState::PREPARATION->value => 5,
            GameState::DAY->value => $currentDay === 0 ? 20 : 5,
            GameState::VOTING->value => 20,
            GameState::DEFENSE->value => 20,
            GameState::JUDGMENT->value => 20,
            GameState::LAST_WORDS->value => 10,
            GameState::NIGHT->value => 5,
            GameState::REVEAL->value => 5,
            GameState::GAME_OVER->value => 5
        ];

        // If the next state is in the timerValues array, set the countdown_end
        if (array_key_exists($nextState->value, $timerValues)) {
            $this->lobby->update(['countdown_start' => now(), 'countdown_end' => now()->addSeconds($timerValues[$nextState->value])]);
        }

        $this->runStateEnterEvents($nextState);

        // Broadcast the updated state to all users in the lobby.
        broadcast(new GameStateUpdated($this->lobby->id, $nextState));
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
