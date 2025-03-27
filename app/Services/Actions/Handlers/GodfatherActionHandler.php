<?php

namespace App\Services\Actions\Handlers;

use App\Models\ZalimKasaba\Lobby;
use App\Enums\ZalimKasaba\ActionType;
use App\Enums\ZalimKasaba\PlayerRole;
use App\Models\ZalimKasaba\GameAction;
use App\Traits\ZalimKasaba\ChatManager;
use App\Traits\ZalimKasaba\PlayerActionsManager;
use App\Enums\ZalimKasaba\ChatMessageType;

class GodfatherActionHandler implements ActionHandlerInterface
{
    use ChatManager, PlayerActionsManager;

    public Lobby $lobby;

    public function __construct(Lobby $lobby)
    {
        $this->lobby = $lobby;
    }

    public function handle(GameAction $action): void
    {
        // If the godfather is roleblocked, they can't perform their action
        if ($action->is_roleblocked) {
            return;
        }

        $players = $this->lobby->players()->where('is_alive', true)->get();

        $mafioso = $players->where('role.enum', PlayerRole::MAFIOSO)
            ->first();

        if ($mafioso) {
            // Check if Mafioso has already selected a target
            $mafiosoAction = $this->lobby->actions()
                ->where('actor_id', $mafioso->id)
                ->where('action_type', ActionType::KILL)
                ->first();

            if ($mafiosoAction) {
                // Delete the mafioso's own action, they are obeying the Godfather
                $mafiosoAction->delete();
            }

            // Create a new KILL action for the Mafioso instead of updating the existing one
            $this->lobby->actions()->create([
                'actor_id' => $mafioso->id,
                'target_id' => $action->target_id,
                'action_type' => ActionType::KILL,
            ]);

            // Notify the mafioso.
            $this->sendMessageToPlayer($mafioso, "Baron seni hedefini öldürmeye gönderdi.");

            // Delete the original godfather action so the lookout doesn't see the godfather visiting
            // This must be done AFTER creating the new mafioso action
            $action->delete();
        } else {
            // No Mafioso exists, so Godfather will execute the kill instead
            // Create a new KILL action for the Godfather
            $newAction = $this->lobby->actions()->create([
                'actor_id' => $action->actor_id,
                'target_id' => $action->target_id,
                'action_type' => ActionType::KILL,
            ]);

            // Delete the original action to avoid duplication
            if ($newAction->id != $action->id) {
                $action->delete();
            }
        }
    }
}
