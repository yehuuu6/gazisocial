<?php

namespace App\Traits\ZalimKasaba;

use App\Enums\ZalimKasaba\GameState;
use App\Enums\ZalimKasaba\PlayerRole;
use App\Enums\ZalimKasaba\ChatMessageType;

trait StateEnterEvents
{
    use ChatManager, PlayerActionsManager;

    private function enterDay()
    {
        // Delete all actions
        $this->lobby->actions()->delete();

        // Announce dead players
        $deadPlayers = $this->lobby->players()
            ->where('is_alive', false)
            ->where('is_hanged', false)
            ->where('death_night', $this->lobby->day_count - 1)->get();
        if ($deadPlayers->isNotEmpty()) {
            $deadPlayersString = $deadPlayers->map(function ($player) {
                return $player->user->username;
            })->implode(', ');
            $this->sendSystemMessage("Gece ölenler: {$deadPlayersString}");

            $this->lobby->update(['last_death_night' => $this->lobby->day_count - 1]);
        }

        $this->checkGameOver();

        // Draw the game if there are no deaths for 5 days straight
        if ($this->lobby->day_count - $this->lobby->last_death_night >= 5) {
            $players = $this->lobby->players;
            $townPlayers = $players->filter(function ($player) {
                return in_array($player->role->enum, PlayerRole::getTownRoles());
            });
            $aliveTownPlayers = $townPlayers->where('is_alive', true);
            $neutralWinners = $this->calculateWinners($aliveTownPlayers);
            // If there are winners in the winners array
            if (count($neutralWinners) > 0) {
                $this->sendSystemMessage('Oyun berabere bitti. Kazananlar: ' . implode(', ', $neutralWinners));
            } else {
                $this->sendSystemMessage('Oyun berabere bitti. Kimse kazanamadı.');
            }
            $this->nextState(GameState::GAME_OVER);
            return;
        }

        // Check if there are no deaths for 4 days
        if ($this->lobby->day_count - $this->lobby->last_death_night === 4) {
            $this->sendSystemMessage('Yarına kadar kimse ölmezse, oyun berabere bitecek.', ChatMessageType::WARNING);
            return;
        }

        if ($this->lobby->state !== GameState::GAME_OVER) {
            $this->sendSystemMessage('Gün aydınlandı, kasaba uyanıyor.');
        }
    }

    private function enterVoting()
    {
        $this->lobby->finalVotes()->delete();
        // Use the aliased method if it exists, otherwise try the original method
        $threshold = method_exists($this, 'calculateVoteThreshold')
            ? $this->calculateVoteThreshold()
            : $this->calculateRequiredVotes();
        $trialCount = $this->lobby->available_trials;
        $this->sendSystemMessage("Bu gün {$trialCount} oylama yapma hakkınız kaldı. Sorgulama yapmak için {$threshold} oy gerekiyor.");
        $this->lobby->update(['available_trials' => $trialCount - 1]);
    }

    private function enterDefense()
    {
        $accusedPlayer = $this->lobby->accused;
        $this->sendSystemMessage("Sanık {$accusedPlayer->user->username}, kendini savun.");
    }

    private function enterJudgment()
    {
        // Delete all the votes
        $this->lobby->votes()->delete();
    }

    private function enterLastWords()
    {
        $accusedPlayer = $this->lobby->accused;
        $this->sendSystemMessage("Sanık {$accusedPlayer->user->username}, son sözlerini söyle.");
    }

    private function enterNight()
    {
        $players = $this->lobby->players()->with(['guilt', 'poison'])->where('is_alive', true)->get();

        foreach ($players as $player) {
            // Check if the player has poison
            $poison = $player->poison;
            if ($poison && $poison->poisoned_at === $this->lobby->day_count - 1) {
                $this->sendMessageToPlayer(
                    $player,
                    'Zehirin etkisi devam ediyor, bu gece bir doktor seni kurtarmazsa öleceksin!',
                    ChatMessageType::WARNING
                );
            }

            // Check if the player has guilt
            $guilt = $player->guilt;
            if ($guilt && $guilt->night === $this->lobby->day_count) {
                $this->sendMessageToPlayer(
                    $player,
                    'Masum bir köylüyü öldürdüğün için vicdan azabı çekiyorsun...',
                    ChatMessageType::DEFAULT
                );
            }
        }

        // Delete all the votes
        $this->lobby->finalVotes()->delete();
        $this->lobby->votes()->delete();
        $this->lobby->update(['available_trials' => 3]);

        $this->sendNightAbilityMessages();
    }

    private function enterReveal() {}

    private function enterPreparation()
    {
        $this->assignRoles($this->lobby);
        $this->sendSystemMessage('Oyun başladı, herkesin rolü belirlendi.');
    }

    private function enterGameOver()
    {
        //
    }
}
