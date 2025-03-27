<?php

namespace App\Services\Actions\Handlers;

use App\Models\ZalimKasaba\Lobby;
use App\Enums\ZalimKasaba\ActionType;
use App\Enums\ZalimKasaba\PlayerRole;
use App\Models\ZalimKasaba\GameAction;
use App\Traits\ZalimKasaba\ChatManager;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Traits\ZalimKasaba\PlayerActionsManager;

class MafiosoActionHandler implements ActionHandlerInterface
{
    use ChatManager, PlayerActionsManager;

    public Lobby $lobby;

    public function __construct(Lobby $lobby)
    {
        $this->lobby = $lobby;
    }

    public function handle(GameAction $action): void
    {
        // If the mafioso is roleblocked, they can't perform their action
        if ($action->is_roleblocked) {
            return;
        }

        $playerToKill = $action->target;

        if ($playerToKill) {
            // Check if the player was healed
            $wasHealed = false;

            $healActions = $this->lobby->actions()->where('action_type', ActionType::HEAL)->get();

            foreach ($healActions as $healAction) {
                if ($healAction->target_id === $playerToKill->id) {
                    $wasHealed = true;
                    $doctor = $healAction->actor;
                    break;
                }
            }

            if ($wasHealed) {
                // Player was healed, cancel the kill
                $this->sendMessageToPlayer($action->actor, "Hedefinize saldırdınız, ancak biri onu geri hayata döndürdü!", ChatMessageType::WARNING);

                $this->sendMessageToPlayer($doctor, "Hedefiniz saldırıya uğradı, ancak onu kurtardınız!", ChatMessageType::SUCCESS);

                $this->sendMessageToPlayer($playerToKill, "Biri evine girip sana saldırdı, ama bir doktor seni kurtardı!", ChatMessageType::SUCCESS);

                return;
            }

            $targetIsAnAngel = false;

            $angelActions = $this->lobby->actions()->where('action_type', ActionType::REVEAL)->get();

            foreach ($angelActions as $angelAction) {
                if ($angelAction->target_id === $playerToKill->id) {
                    $targetIsAnAngel = true;
                    break;
                }
            }

            if ($targetIsAnAngel) {
                // Player is an angel, cancel the kill
                $this->sendMessageToPlayer($action->actor, "Öldürmek için gittiğin evde bir meleğin güzelliğine yenik düştün. Eve dönüyorsun.", ChatMessageType::WARNING);
                $this->sendMessageToPlayer($playerToKill, "Biri sana saldırmaya çalıştı, ama melek formun onu durdurdu!", ChatMessageType::SUCCESS);
                return;
            }

            $players = $this->lobby->players()->where('is_alive', true)->get();
            $witchPlayer = $players->where('role.enum', PlayerRole::WITCH)->first();

            if ($witchPlayer) {
                if ($playerToKill->id === $witchPlayer->id) {
                    $this->sendMessageToPlayer($action->actor, "Saldırmaya çalıştığın kişinin bir cadı olduğunu fark ettin, onunla iş birliği yapabilirsin.", ChatMessageType::WARNING);
                    $this->sendMessageToPlayer($playerToKill, "Mafya üyelerinden " . $action->actor->user->username . " sana saldırmak istedi, ama sen bir cadısın ve onunla iş birliği yapabilirsin.", ChatMessageType::WARNING);
                    return;
                }
            }


            $this->killPlayer($playerToKill);
            $this->sendMessageToPlayer($playerToKill, "Bir mafya üyesi tarafından öldürüldün!", ChatMessageType::WARNING);
        }
    }
}
