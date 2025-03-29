<?php

namespace App\Traits\ZalimKasaba;

use Illuminate\Support\Collection;
use App\Enums\ZalimKasaba\GameState;
use App\Enums\ZalimKasaba\PlayerRole;
use App\Enums\ZalimKasaba\FinalVoteType;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Events\GameEnded;
use App\Jobs\DeleteLobby;
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
            $this->killPlayer($accused);
            $this->sendSystemMessage(
                "{$username} kasaba tarafından idam edildi. Oyuncunun rolü: {$roleIcon} {$roleName}."
            );

            $accused->update(['is_hanged' => true]);

            if ($accused->role->enum === PlayerRole::JESTER) {
                $accused->update(['can_haunt' => true]);
                $this->sendSystemMessage('Zibidi mezardan intikamını alacak! 🤡', type: ChatMessageType::WARNING);
            }
        }

        $this->lobby->update(['accused_id' => null]);

        $this->checkGameOver();

        $this->promoteJanitor();
    }

    private function exitNight()
    {
        $this->validateEvent(GameState::NIGHT);

        $this->informAbiltyWasted();

        $processor = new NightActionProcessor(new ActionHandlerFactory($this->lobby));
        $processor->processActionsForLobby($this->lobby);

        $this->processGuilts();
        $this->processPoisons();

        $this->promoteJanitor();
    }

    private function promoteJanitor()
    {
        // Convert the janitor to mafioso if the godfather or the mafioso is no longer alive.
        $players = $this->lobby->players()->get();

        $godfatherPlayer = $players->where('role.enum', PlayerRole::GODFATHER)->where('is_alive', true)->first();
        $mafiosoPlayer = $players->where('role.enum', PlayerRole::MAFIOSO)->where('is_alive', true)->first();

        if (!$godfatherPlayer && !$mafiosoPlayer) {
            $janitorPlayer = $players->where('role.enum', PlayerRole::JANITOR)->where('is_alive', true)->first();

            if ($janitorPlayer) {
                $janitorPlayer->update([
                    'game_role_id' => 2,
                    'ability_uses' => null
                ]);
                $this->sendMessageToPlayer($janitorPlayer, 'Tetikçi rolüne terfi ettiniz.');
            }
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

        // Dispatch the DeleteLobby job
        dispatch(new DeleteLobby($this->lobby->id));

        broadcast(new GameEnded($this->lobby->id))->toOthers();

        // Return everyone to the guide page
        return redirect(route('games.zk.guide'))
            ->with('success', 'Oyun sona erdi. Başka bir oyuna katılabilirsiniz.');
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
