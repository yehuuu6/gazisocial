<?php

namespace App\Services\Actions\Handlers;

use App\Enums\ZalimKasaba\ActionType;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Models\ZalimKasaba\GameAction;
use App\Models\ZalimKasaba\Lobby;
use App\Traits\ZalimKasaba\ChatManager;
use App\Traits\ZalimKasaba\PlayerActionsManager;

class GuardActionHandler implements ActionHandlerInterface
{
    use ChatManager, PlayerActionsManager;

    public Lobby $lobby;

    public function __construct(Lobby $lobby)
    {
        $this->lobby = $lobby;
    }

    public function handle(GameAction $action): void
    {
        // Get the target player
        $targetPlayer = $action->target;

        // Mark the target as roleblocked in the database
        $targetAction = $this->lobby->actions()
            ->where('actor_id', $action->target_id)
            ->first();

        if ($targetAction) {
            $targetAction->update(['is_roleblocked' => true]);
        }

        $this->sendMessageToPlayer($targetPlayer, "Bekçi seni durdurdu ve kimlik kontrolü yaptı. Geceyi evde geçireceksin.", ChatMessageType::WARNING);
    }
}
