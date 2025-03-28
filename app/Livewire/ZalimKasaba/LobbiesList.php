<?php

namespace App\Livewire\ZalimKasaba;

use App\Enums\ZalimKasaba\GameState;
use Livewire\Component;
use App\Models\ZalimKasaba\Lobby;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('Zalim Kasaba Oyun Lobileri - Gazi Social')]
class LobbiesList extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Layout('layout.games')]
    public function render()
    {
        return view('livewire.zalim-kasaba.lobbies-list', [
            'lobbies' => Lobby::where('is_listed', true)
                ->where('state', GameState::LOBBY)
                ->latest()
                ->with(['host'])
                ->simplePaginate(20),
        ])->title('Zalim Kasaba Oyun Lobileri - Gazi Social');
    }
}
