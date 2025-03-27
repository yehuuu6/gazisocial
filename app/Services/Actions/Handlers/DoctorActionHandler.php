<?php

namespace App\Services\Actions\Handlers;

use App\Enums\ZalimKasaba\ActionType;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Models\ZalimKasaba\GameAction;
use App\Models\ZalimKasaba\Lobby;
use App\Traits\ZalimKasaba\ChatManager;
use App\Traits\ZalimKasaba\PlayerActionsManager;

class DoctorActionHandler implements ActionHandlerInterface
{
    use ChatManager, PlayerActionsManager;

    public Lobby $lobby;

    public function __construct(Lobby $lobby)
    {
        $this->lobby = $lobby;
    }

    public function handle(GameAction $action): void
    {
        // If the doctor is roleblocked, they can't perform their action
        if ($action->is_roleblocked) {
            return;
        }

        // If the doctor healed themselves, mark as self-healed
        if ($action->actor_id === $action->target_id) {
            $action->actor->update(['self_healed' => true]);
        }
    }
}
