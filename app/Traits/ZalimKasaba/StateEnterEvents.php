<?php

namespace App\Traits\ZalimKasaba;

use App\Enums\ZalimKasaba\ChatMessageType;
use App\Enums\ZalimKasaba\PlayerRole;

trait StateEnterEvents
{
    use ChatManager, PlayerActionsManager;

    private function enterDay()
    {
        // Delete all actions
        $this->lobby->actions()->delete();
        $this->sendSystemMessage('Gün aydınlandı, kasaba uyanıyor.');
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
        $offlinePlayers = $this->lobby->players()->where('is_online', false)->get();
        foreach ($offlinePlayers as $offlinePlayer) {
            //$this->killPlayer($offlinePlayer);
        }

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

    private function enterReveal()
    {
        $this->lobby->players()
            ->where('is_alive', true);

        $deadPlayers = $this->lobby->players()
            ->where('is_alive', false)
            ->where('death_night', $this->lobby->day_count)
            ->get();
    }

    private function enterPreparation()
    {
        $this->assignRoles($this->lobby);
        $this->sendSystemMessage('Oyun başladı, herkesin rolü belirlendi.');
    }
}
