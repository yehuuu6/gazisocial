<?php

namespace App\Livewire\ZalimKasaba;

use Livewire\Component;
use App\Models\ZalimKasaba\Lobby;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Oyun Lobileri - Zalim Kasaba')]
class LobbiesList extends Component
{
    #[Layout('layout.games')]
    public function render()
    {
        return view('livewire.zalim-kasaba.lobbies-list', [
            'lobbies' => Lobby::latest()->with(['host'])->get()
        ]);
    }
}
