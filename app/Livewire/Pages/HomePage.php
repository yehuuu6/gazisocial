<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layout.app')]
class HomePage extends Component
{
    public function render()
    {
        return view('livewire.pages.home-page');
    }
}
