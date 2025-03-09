<?php

namespace App\Livewire\Games\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;

class GamesList extends Component
{
    #[Layout('layout.games')]
    public function render()
    {
        return view('livewire.games.pages.games-list');
    }
}
