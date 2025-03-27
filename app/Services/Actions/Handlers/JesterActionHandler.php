<?php

namespace App\Services\Actions\Handlers;

use App\Enums\ZalimKasaba\ChatMessageType;
use App\Models\ZalimKasaba\GameAction;
use App\Models\ZalimKasaba\Lobby;
use App\Traits\ZalimKasaba\ChatManager;
use App\Traits\ZalimKasaba\PlayerActionsManager;

class JesterActionHandler implements ActionHandlerInterface
{
    use ChatManager, PlayerActionsManager;

    public Lobby $lobby;

    public function __construct(Lobby $lobby)
    {
        $this->lobby = $lobby;
    }

    public function handle(GameAction $action): void
    {
        $targetPlayer = $action->target;

        if (!$targetPlayer) {
            return;
        }

        if ($action->actor->is_alive) {
            return;
        }

        if (!$action->actor->can_haunt || $this->lobby->day_count !== $action->actor->death_night) {
            return;
        }

        // Kill the target
        $this->killPlayer($targetPlayer);

        $this->sendMessageToPlayer($targetPlayer, 'Zibidi seni lanetledi, öldürüldün!', ChatMessageType::WARNING);
    }
}
