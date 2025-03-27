<?php

namespace App\Services\Actions\Handlers;

use App\Enums\ZalimKasaba\ActionType;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Enums\ZalimKasaba\PlayerRole;
use App\Models\ZalimKasaba\GameAction;
use App\Models\ZalimKasaba\Lobby;
use App\Traits\ZalimKasaba\ChatManager;
use App\Traits\ZalimKasaba\PlayerActionsManager;

class HunterActionHandler implements ActionHandlerInterface
{
    use ChatManager, PlayerActionsManager;

    public Lobby $lobby;

    public function __construct(Lobby $lobby)
    {
        $this->lobby = $lobby;
    }

    public function handle(GameAction $action): void
    {
        // If the hunter is roleblocked, they can't perform their action
        if ($action->is_roleblocked) {
            return;
        }

        $targetPlayer = $action->target;

        if (!$targetPlayer) {
            return;
        }


        $healActions = $this->lobby->actions()->where('action_type', ActionType::HEAL)->get();

        // Check if the target was healed
        $wasHealed = false;
        foreach ($healActions as $healAction) {
            if ($healAction->target_id === $targetPlayer->id) {
                $wasHealed = true;
                $doctor = $healAction->actor;
                break;
            }
        }

        if ($wasHealed) {
            // Target was healed, shot is unsuccessful
            $this->sendMessageToPlayer($action->actor, "Hedefinize ateş ettiniz, ancak biri onu kurtardı!", ChatMessageType::WARNING);
            $this->sendMessageToPlayer($doctor, 'Hedefin saldırıya uğradı, ancak onu kurtardın!', ChatMessageType::SUCCESS);
            $this->sendMessageToPlayer($targetPlayer, 'Biri evine girip sana saldırdı, ama bir doktor seni kurtardı!', ChatMessageType::SUCCESS);
            return;
        }

        $targetIsAnAngel = false;

        $angelActions = $this->lobby->actions()->where('action_type', ActionType::REVEAL)->get();

        foreach ($angelActions as $angelAction) {
            if ($angelAction->target_id === $targetPlayer->id) {
                $targetIsAnAngel = true;
                break;
            }
        }

        if ($targetIsAnAngel) {
            // Player is an angel, cancel the kill
            $this->sendMessageToPlayer($action->actor, "Öldürmek için gittiğin evde bir meleğin güzelliğine yenik düştün. Eve dönüyorsun.", ChatMessageType::WARNING);
            $this->sendMessageToPlayer($targetPlayer, "Biri sana saldırmaya çalıştı, ama melek formun onu durdurdu!", ChatMessageType::SUCCESS);
            return;
        }

        $players = $this->lobby->players()->where('is_alive', true)->get();
        $witchPlayer = $players->where('role.enum', PlayerRole::WITCH)->first();
        $angelPlayers = $players->where('role.enum', PlayerRole::ANGEL);
        $doctorPlayers = $players->where('role.enum', PlayerRole::DOCTOR);
        $guardPlayers = $players->where('role.enum', PlayerRole::GUARD);

        $possibleMessages = [];
        if ($doctorPlayers->isNotEmpty()) {
            $possibleMessages[] = 'Hedefinize ateş ettiniz, ancak biri onu kurtardı!';
        }
        if ($angelPlayers->isNotEmpty()) {
            $possibleMessages[] = 'Öldürmek için gittiğin evde bir meleğin güzelliğine yenik düştün. Eve dönüyorsun.';
        }
        if ($guardPlayers->isNotEmpty()) {
            $possibleMessages[] = 'Bekçi seni durdurdu ve kimlik kontrolü yaptı. Geceyi evde geçireceksin.';
        }

        if ($witchPlayer) {
            if ($targetPlayer->id === $witchPlayer->id) {
                // Choose one of the messages randomly
                if (count($possibleMessages) > 0) {
                    $message = $possibleMessages[array_rand($possibleMessages)];
                    $this->sendMessageToPlayer($action->actor, $message, ChatMessageType::WARNING);
                } else {
                    $this->sendMessageToPlayer($action->actor, "Hedefinize ateş ettiniz, ancak silah tutukluk yaptı!", ChatMessageType::WARNING);
                }
                $this->sendMessageToPlayer($targetPlayer, "Bir avcı seni öldürmeyi denedi, ama sen onun zihnine sahte bir görüntü yerleştirdin ve kurtuldun.", ChatMessageType::WARNING);
                return;
            }
        }

        // Kill the target
        $this->killPlayer($targetPlayer);

        $this->sendMessageToPlayer($targetPlayer, 'Bir avcı tarafından vuruldun!', ChatMessageType::WARNING);
        // Check if the target was a town role
        if (in_array($targetPlayer->role->enum, PlayerRole::getTownRoles())) {
            // Mark hunter for suicide next day
            $hunterPlayer = $action->actor;

            $this->lobby->guilts()->create([
                'player_id' => $hunterPlayer->id,
                'night' => $this->lobby->day_count + 1,
            ]);
        }
    }
}
