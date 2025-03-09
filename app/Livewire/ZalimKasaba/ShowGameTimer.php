<?php

namespace App\Livewire\ZalimKasaba;

use App\Enums\ZalimKasaba\GameState;
use App\Models\ZalimKasaba\Lobby;
use Livewire\Component;

class ShowGameTimer extends Component
{
    public Lobby $lobby;
    public bool $isStarted = false;
    public string $startTime;
    public string $endTime;

    public function mount(Lobby $lobby)
    {
        $this->lobby = $lobby;

        $this->setValues();
    }

    private function setValues()
    {
        $this->startTime = $this->lobby->countdown_start ? $this->lobby->countdown_start->toIso8601String() : '';
        $this->endTime = $this->lobby->countdown_end ? $this->lobby->countdown_end->toIso8601String() : '';

        $this->isStarted = $this->lobby->state !== GameState::LOBBY;
        $this->dispatch('game-state-updated');
    }

    public function getListeners()
    {
        return [
            "echo-presence:zalim-kasaba-lobby.{$this->lobby->id},.game.state.updated" => 'handleGameStateUpdated',
        ];
    }

    public function handleGameStateUpdated($payload)
    {
        $this->setValues();
    }

    public function render()
    {
        return view('livewire.zalim-kasaba.show-game-timer');
    }
}
