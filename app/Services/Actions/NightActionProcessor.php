<?php

namespace App\Services\Actions;

use App\Models\ZalimKasaba\Lobby;
use Illuminate\Support\Facades\DB;
use App\Enums\ZalimKasaba\ActionType;
use App\Models\ZalimKasaba\GameAction;

class NightActionProcessor
{
    protected ActionHandlerFactory $actionHandlerFactory;

    public function __construct(ActionHandlerFactory $factory)
    {
        $this->actionHandlerFactory = $factory;
    }

    public function processActionsForLobby(Lobby $lobby): void
    {
        // Initialize healActions array for this night - using a local variable
        $healActions = [];

        // Get all possible priority levels
        $priorities = array_unique(array_map(function ($type) {
            return $this->getPriority($type);
        }, ActionType::cases()));

        sort($priorities);

        // Process actions by priority level
        foreach ($priorities as $priority) {
            // Fetch actions of the current priority level
            $actions = $lobby->actions()
                ->with(['actor', 'target'])
                ->get()
                ->filter(fn($action) => $this->getPriority($action->action_type) === $priority);

            foreach ($actions as $action) {
                $handler = $this->actionHandlerFactory->getHandler($action->action_type);
                if ($handler) {
                    // Pass healActions array to handle method
                    $handler->handle($action, $healActions);
                }
            }
        }
    }

    protected function getPriority(ActionType $actionType): int
    {
        return match ($actionType) {
            ActionType::INTERROGATE => 1,
            ActionType::ORDER => 2,
            ActionType::HEAL => 3,
            ActionType::KILL => 4,
            default => 99,
        };
    }
}
