<?php

namespace App\Traits\ZalimKasaba;

use Illuminate\Support\Collection;
use App\Enums\ZalimKasaba\GameState;
use App\Enums\ZalimKasaba\PlayerRole;
use App\Enums\ZalimKasaba\FinalVoteType;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Services\Actions\ActionHandlerFactory;
use App\Services\Actions\NightActionProcessor;

trait StateExitEvents
{
    use ChatManager, PlayerActionsManager, VoteManager;

    private function exitLobby()
    {
        $this->validateEvent(GameState::LOBBY);
    }

    private function exitDay()
    {
        $this->validateEvent(GameState::DAY);

        if ($this->lobby->day_count === 1) {
            $this->nextState(GameState::NIGHT);
            return;
        }
    }

    private function exitVoting()
    {
        $this->validateEvent(GameState::VOTING);

        $accusedPlayerId = $this->getAccusedPlayer();
        if (!$accusedPlayerId) {
            $this->sendSystemMessage('Oy birliği sağlanamadı. Oylama bitti.');
            $this->nextState(GameState::NIGHT);
            return;
        }
        $this->lobby->update(['accused_id' => $accusedPlayerId]);
    }

    private function exitDefense()
    {
        $this->validateEvent(GameState::DEFENSE);
    }

    private function exitJudgment()
    {
        $this->validateEvent(GameState::JUDGMENT);

        $judgmentResult = $this->calculateFinalVotes();

        $msgType = $judgmentResult['type'] === FinalVoteType::GUILTY->value ? ChatMessageType::WARNING : ChatMessageType::SUCCESS;

        $this->sendSystemMessage(
            "Yargılama süreci sona erdi. {$judgmentResult['guilty']} suçlu, {$judgmentResult['inno']} masum oy aldı. {$judgmentResult['abstain']} oy çekimser kaldı.",
            $msgType
        );

        if ($judgmentResult['type'] === FinalVoteType::GUILTY->value) {
            // Guilty verdict: Transition to LAST_WORDS and send a message
            $accused = $this->lobby->accused;
            if ($accused) {
                $this->sendSystemMessage("{$accused->user->username} suçlu bulundu. Son sözlerini söylemesi için süre tanınıyor.");
            }
            $this->nextState(GameState::LAST_WORDS);
        } else {
            // Innocent verdict: Proceed as in your original logic
            $this->lobby->update(['accused_id' => null]);
            if ($this->lobby->available_trials > 0) {
                $this->sendSystemMessage('Mahkeme karar veremedi. Yeni bir oylama başlatılıyor.');
                $this->nextState(GameState::VOTING);
            } else {
                $this->sendSystemMessage('Oylama hakkınız kalmadı. Geceye geçiliyor.');
                $this->nextState(GameState::NIGHT);
            }
        }
    }

    private function exitLastWords()
    {
        $this->validateEvent(GameState::LAST_WORDS);

        $accused = $this->lobby->accused;
        $username = $accused->user->username;
        $roleName = $accused->role->name;
        $roleIcon = $accused->role->icon;
        if ($accused) {
            //$this->killPlayer($accused, $accused->role->enum === PlayerRole::JESTER, true);
            $this->sendSystemMessage(
                "{$username} kasaba tarafından idam edildi. Oyuncunun rolü: {$roleIcon} {$roleName}."
            );
        }

        $this->lobby->update(['accused_id' => null]);
    }

    private function exitNight()
    {
        $this->validateEvent(GameState::NIGHT);

        $this->informAbiltyWasted();

        $processor = new NightActionProcessor(new ActionHandlerFactory($this->lobby));
        $processor->processActionsForLobby($this->lobby);

        // If there are no deaths, skip to the day phase
        $deadPlayers = $this->lobby->players()->where('is_alive', false)->where('death_night', $this->lobby->day_count)->get();
        if ($deadPlayers->count() === 0) {
            $this->sendSystemMessage('Gece kimse ölmedi.');
        }
    }

    private function exitReveal()
    {
        $this->validateEvent(GameState::REVEAL);
    }

    private function exitPreparation()
    {
        $this->validateEvent(GameState::PREPARATION);
    }

    private function exitGameOver()
    {
        if ($this->lobby->state !== GameState::GAME_OVER) return false;
    }

    // FUNCTIONS START

    /**
     * Validate the event before the exit event is fired.
     * @param GameState $currentState
     * @return bool
     */
    private function validateEvent(GameState $currentState): bool
    {
        if (!$this->currentPlayer->is_host) return false;
        if ($this->lobby->state !== $currentState) return false;
        return true;
    }

    /**
     * Send a message to players who did not use their ability during the night phase.
     * @param Collection $actions
     * @param Collection $players
     * @return void
     */
    private function informAbiltyWasted(): void
    {
        $players = $this->lobby->players()->get();
        $actions = $this->lobby->actions()->get();

        foreach ($players as $player) {
            // Check ability usage for living players with roles
            if ($player->is_alive) {
                $playerActions = $actions->where('actor_id', $player->id);
                if ($playerActions->count() === 0 && $player->is_alive && $player->ability_uses > 0) {
                    $this->sendMessageToPlayer($player, 'Gece yeteneğinizi kullanmadınız.');
                } else {
                    if ($player->ability_uses > 0) {
                        $player->decrement('ability_uses');
                    }
                }
            }
        }
    }
}
