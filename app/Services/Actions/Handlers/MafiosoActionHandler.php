<?php

namespace App\Services\Actions\Handlers;

use App\Enums\ZalimKasaba\ActionType;
use App\Models\ZalimKasaba\GameAction;
use App\Models\ZalimKasaba\Player;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Models\ZalimKasaba\Lobby;
use App\Traits\ZalimKasaba\ChatManager;
use App\Traits\ZalimKasaba\PlayerActionsManager;
use Masmerise\Toaster\Toaster;

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

        $playerToKill = $this->lobby->players()->where('id', $action->target_id)->first();

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

            $this->killPlayer($playerToKill);
            $this->sendMessageToPlayer($playerToKill, "Biri evine girdi, öldürüldün!", ChatMessageType::WARNING);
        }
    }

    private function killPlayer(Player $player): void
    {
        $player->update([
            'is_alive' => false,
            'death_night' => $this->lobby->day_count,
        ]);
    }
}
