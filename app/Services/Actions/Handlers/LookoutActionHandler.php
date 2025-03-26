<?php

namespace App\Services\Actions\Handlers;

use App\Enums\ZalimKasaba\ActionType;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Models\ZalimKasaba\GameAction;
use App\Models\ZalimKasaba\Lobby;
use App\Traits\ZalimKasaba\ChatManager;
use App\Traits\ZalimKasaba\PlayerActionsManager;

class LookoutActionHandler implements ActionHandlerInterface
{
    use ChatManager, PlayerActionsManager;

    public Lobby $lobby;

    // Store a list of visitors for each player
    protected array $visitors = [];

    public function __construct(Lobby $lobby)
    {
        $this->lobby = $lobby;
    }

    public function handle(GameAction $action, array &$healActions = []): void
    {
        // If the lookout is roleblocked, they can't perform their action
        if ($action->is_roleblocked) {
            return;
        }

        // Store this lookout action for later processing
        $this->visitors[$action->id] = [
            'lookout' => $action->actor,
            'target_id' => $action->target_id
        ];
    }

    /**
     * Process all lookout actions after all other actions have been handled
     * This should be called by the NightActionProcessor at the end of processing
     */
    public function processLookoutActions(array $allActions): void
    {
        // Skip if no lookout actions
        if (empty($this->visitors)) {
            return;
        }

        // For each lookout action
        foreach ($this->visitors as $lookoutData) {
            $targetId = $lookoutData['target_id'];
            $lookoutPlayer = $lookoutData['lookout'];
            $target = $this->lobby->players()->where('id', $targetId)->first();

            if (!$lookoutPlayer || !$target) {
                continue;
            }

            // Find all actions targeting this player
            $visitors = [];

            foreach ($allActions as $action) {
                // Skip lookout's own action
                if ($action->action_type === ActionType::WATCH) {
                    continue;
                }

                // Skip actions that aren't targeting this player
                if ($action->target_id !== $targetId) {
                    continue;
                }

                // Skip actions that have been deleted (check if action still exists in DB)
                try {
                    $existingAction = GameAction::find($action->id);
                    if (!$existingAction) {
                        continue;
                    }
                } catch (\Exception $e) {
                    continue;
                }

                // Add the visitor to the list if not already there
                $actorId = $action->actor_id;
                if (!isset($visitors[$actorId])) {
                    $visitors[$actorId] = $action->actor;
                }
            }

            // Send a message to the lookout with the results
            if (empty($visitors)) {
                $this->sendMessageToPlayer(
                    $lookoutPlayer,
                    'Hedefin bu gece kimse tarafından ziyaret edilmedi.',
                    ChatMessageType::DEFAULT
                );
            } else {
                $visitorNames = collect($visitors)->map(function ($visitor) {
                    return $visitor->user->username;
                })->join(', ');

                $this->sendMessageToPlayer(
                    $lookoutPlayer,
                    "Hedefin {$visitorNames} tarafından ziyaret edildi.",
                    ChatMessageType::SUCCESS
                );
            }
        }
    }
}
