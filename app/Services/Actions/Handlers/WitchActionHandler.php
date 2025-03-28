<?php

namespace App\Services\Actions\Handlers;

use App\Models\ZalimKasaba\Lobby;
use App\Enums\ZalimKasaba\ActionType;
use App\Enums\ZalimKasaba\PlayerRole;
use App\Models\ZalimKasaba\GameAction;
use App\Traits\ZalimKasaba\ChatManager;
use App\Enums\ZalimKasaba\ChatMessageType;
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

        $playerToPoison = $action->target;

        if (
            $playerToPoison->role->enum === PlayerRole::MAFIOSO ||
            $playerToPoison->role->enum === PlayerRole::GODFATHER ||
            $playerToPoison->role->enum === PlayerRole::JANITOR
        ) {
            $this->sendMessageToPlayer($action->actor, "Zehirlemeye çalıştığın kişinin mafya üyesi olduğunu fark ettin, onunla iş birliği yapabilirsin.", ChatMessageType::WARNING);
            $this->sendMessageToPlayer($playerToPoison, "Cadı " . $action->actor->user->username . " seni zehirlemek istedi, ama mafya üyesi olduğun için vazgeçti.", ChatMessageType::WARNING);
            return;
        }

        if ($playerToPoison->role->enum === PlayerRole::ANGEL) {
            $angelAction = $this->lobby->actions()->where('action_type', ActionType::REVEAL)->where('actor_id', $playerToPoison->id)->first();
            if ($angelAction) {
                $this->sendMessageToPlayer($action->actor, "Zehirlemek için gittiğin evde bir meleğin güzelliğine yenik düştün. Eve dönüyorsun.", ChatMessageType::WARNING);
                $this->sendMessageToPlayer($playerToPoison, "Biri seni zehirlemeye çalıştı, ama melek formun onu durdurdu!", ChatMessageType::SUCCESS);
                return;
            }
        }

        $this->sendMessageToPlayer($playerToPoison, 'Bir cadı tarafından zehirlendin!', ChatMessageType::WARNING);

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
