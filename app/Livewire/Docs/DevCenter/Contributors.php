<?php

namespace App\Livewire\Docs\DevCenter;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Contributors - Gazi Social Dev Center')]
class Contributors extends Component
{
    public function render()
    {
        return view('livewire.docs.dev-center.contributors');
    }
}
