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
        // Get all possible priority levels
        $priorities = array_unique(array_map(function ($type) {
            return $this->getPriority($type);
        }, ActionType::cases()));

        sort($priorities);

        // Process actions by priority level
        foreach ($priorities as $priority) {
            // For each priority level, refetch the actions from the database
            // to ensure we get any actions that were created by previous handlers
            $actions = $lobby->actions()
                ->with(['actor', 'target'])
                ->get()
                ->filter(fn($action) => $this->getPriority($action->action_type) === $priority);

            foreach ($actions as $action) {
                $handler = $this->actionHandlerFactory->getHandler($action->action_type);
                if ($handler) {
                    // Pass array to handle method
                    $handler->handle($action);
                }
            }
        }

        // Process janitor cleaning after all actions are handled
        $janitorHandler = $this->actionHandlerFactory->getJanitorHandler();
        if ($janitorHandler) {
            $janitorHandler->processCleaningResults();
        }

        // Process lookout actions at the end
        $lookoutHandler = $this->actionHandlerFactory->getLookoutHandler();
        if ($lookoutHandler) {
            $lookoutHandler->processLookoutActions();
        }
    }

    protected function getPriority(ActionType $actionType): int
    {
        return match ($actionType) {
            ActionType::INTERROGATE => 1,
            ActionType::ORDER => 2,
            ActionType::HEAL => 3,
            ActionType::KILL => 4,
            ActionType::SHOOT => 5,
            ActionType::POISON => 6,
            ActionType::CLEAN => 7,
            ActionType::HAUNT => 8,
            default => 99,
        };
    }
}
