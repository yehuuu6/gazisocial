<?php

namespace App\Services\Actions\Handlers;

use App\Enums\ZalimKasaba\ActionType;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Models\ZalimKasaba\GameAction;
use App\Models\ZalimKasaba\Lobby;
use App\Traits\ZalimKasaba\ChatManager;
use App\Traits\ZalimKasaba\PlayerActionsManager;
use Masmerise\Toaster\Toaster;

class JanitorActionHandler implements ActionHandlerInterface
{
    use ChatManager, PlayerActionsManager;

    public Lobby $lobby;

    // Store cleaning targets
    protected array $cleaningTargets = [];

    public function __construct(Lobby $lobby)
    {
        $this->lobby = $lobby;
    }

    public function handle(GameAction $action, array &$healActions = []): void
    {
        // If the janitor is roleblocked, they can't perform their action
        if ($action->is_roleblocked) {
            return;
        }

        // Store this cleaning target for later processing
        // We need to wait to know if the target dies tonight
        $this->cleaningTargets[$action->target_id] = $action->actor_id;
    }

    /**
     * Process all cleaning actions after kills
     * This should be called by the NightActionProcessor at the end of kill processing
     */
    public function processCleaningResults(): void
    {
        // Skip if no cleaning targets
        if (empty($this->cleaningTargets)) {
            return;
        }

        // For each cleaning target
        foreach ($this->cleaningTargets as $targetId => $janitorId) {
            $target = $this->lobby->players()->where('id', $targetId)->first();
            $janitor = $this->lobby->players()->where('id', $janitorId)->first();

            if (!$target || !$janitor) {
                continue;
            }

            // Only clean if the target died this night
            if (!$target->is_alive && $target->death_night === $this->lobby->day_count) {
                // Mark the player as cleaned
                $target->update(['is_cleaned' => true]);
            }
        }
    }
}
