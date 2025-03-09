<?php

namespace App\Livewire\ZalimKasaba;

use Livewire\Component;
use Livewire\Attributes\Layout;

class ZKGuide extends Component
{
    #[Layout('layout.games')]
    public function render()
    {
        return view('livewire.zalim-kasaba.z-k-guide');
    }
}
