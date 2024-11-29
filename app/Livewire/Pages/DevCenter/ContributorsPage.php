<?php

namespace App\Livewire\Pages\DevCenter;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Contributors - Gazi Social Dev Center')]
class ContributorsPage extends Component
{
    public function render()
    {
        return view('livewire.pages.dev-center.contributors-page');
    }
}
