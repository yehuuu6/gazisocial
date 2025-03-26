<?php

namespace App\Services\Actions;

use App\Enums\ZalimKasaba\ActionType;
use App\Models\ZalimKasaba\Lobby;
use App\Services\Actions\Handlers\{
    GodfatherActionHandler, 
    MafiosoActionHandler, 
    DoctorActionHandler,
    GuardActionHandler,
    ActionHandlerInterface
};

class ActionHandlerFactory
{
    protected array $handlers = [];

    public Lobby $lobby;

    public function __construct(Lobby $lobby)
    {
        $this->lobby = $lobby;

        $this->handlers = [
            ActionType::ORDER->value => new GodfatherActionHandler($lobby),
            ActionType::KILL->value => new MafiosoActionHandler($lobby),
            ActionType::HEAL->value => new DoctorActionHandler($lobby),
            ActionType::INTERROGATE->value => new GuardActionHandler($lobby),
        ];
    }

    public function getHandler(ActionType $actionType): ?ActionHandlerInterface
    {
        return $this->handlers[$actionType->value] ?? null;
    }
}
