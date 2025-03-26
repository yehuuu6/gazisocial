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

    public function handle(GameAction $action, array &$healActions = []): void
    {
        // If the godfather is roleblocked, they can't perform their action
        if ($action->is_roleblocked) {
            return;
        }

        $players = $this->lobby->players()->get();

        $mafioso = $players->where('role.enum', PlayerRole::MAFIOSO)
            ->where('is_alive', true)
            ->first();

        if ($mafioso) {
            // Make the mafioso execute the target.
            $action->update([
                'actor_id' => $mafioso->id, // Make Mafioso the killer
                'action_type' => ActionType::KILL, // Convert to kill action
            ]);

            // Check if Mafioso has already selected a target
            $mafiosoAction = $this->lobby->actions()
                ->where('actor_id', $mafioso->id)
                ->where('action_type', ActionType::KILL)
                ->first();

            if ($mafiosoAction) {
                // Delete the mafioso's own action, they are obeying the Godfather
                $mafiosoAction->delete();
            }
        } else {
            // No Mafioso exists, so Godfather will execute the kill instead
            $action->update([
                'action_type' => ActionType::KILL, // Convert to kill action
            ]);
        }
    }
}
