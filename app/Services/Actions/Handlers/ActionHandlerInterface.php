<?php

namespace App\Services\Actions\Handlers;

use App\Models\ZalimKasaba\GameAction;

interface ActionHandlerInterface
{
    /**
     * Handle the given action
     * 
     * @param GameAction $action The action to handle
     * @param array $healedPlayers Reference to the array of healed player IDs
     * @return void
     */
    public function handle(GameAction $action): void;
}
