<?php

namespace App\Livewire\Docs\DevCenter;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Introduction - Gazi Social Dev Center')]
class Introduction extends Component
{
    public function render()
    {
        return view('livewire.docs.dev-center.introduction');
    }
}
