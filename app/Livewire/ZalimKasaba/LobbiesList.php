<?php

namespace App\Livewire\ZalimKasaba;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\ZalimKasaba\Lobby;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;
use App\Enums\ZalimKasaba\GameState;
use Illuminate\Support\Facades\Auth;

#[Title('Zalim Kasaba Oyun Lobileri - Gazi Social')]
class LobbiesList extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Computed]
    public function myLobbies()
    {
        // Return the lobbies I'm in
        return Lobby::whereHas('players', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->latest()
            ->with(['host'])
            ->take(5)
            ->get();
    }

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
