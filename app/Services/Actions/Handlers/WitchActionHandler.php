<?php

namespace App\Services\Actions\Handlers;

use App\Enums\ZalimKasaba\ActionType;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Models\ZalimKasaba\GameAction;
use App\Models\ZalimKasaba\Lobby;
use App\Traits\ZalimKasaba\ChatManager;
use App\Traits\ZalimKasaba\PlayerActionsManager;

class WitchActionHandler implements ActionHandlerInterface
{
    use ChatManager, PlayerActionsManager;

    public Lobby $lobby;

    public function __construct(Lobby $lobby)
    {
        $this->lobby = $lobby;
    }

    public function handle(GameAction $action): void
    {
        // If the Witch is roleblocked, they can't perform their action
        if ($action->is_roleblocked) {
            return;
        }

        $targetPlayer = $action->target;

        if (!$targetPlayer) {
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
            $this->sendMessageToPlayer($action->actor, "Zehirlemek için gittiğin evde bir meleğin güzelliğine yenik düştün. Eve dönüyorsun.", ChatMessageType::WARNING);
            $this->sendMessageToPlayer($targetPlayer, "Biri seni zehirlemeye çalıştı, ama melek formun onu durdurdu!", ChatMessageType::SUCCESS);
            return;
        }

        $this->sendMessageToPlayer($targetPlayer, 'Bir cadı tarafından zehirlendin!', ChatMessageType::WARNING);

        // Create the poison
        $poison = $this->lobby->poisons()->create(
            [
                'target_id' => $action->target_id,
                'poisoner_id' => $action->actor_id,
                'poisoned_at' => $this->lobby->day_count,
            ]
        );
    }
}
