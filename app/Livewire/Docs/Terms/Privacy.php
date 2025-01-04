<?php

namespace App\Livewire\Docs\Terms;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Gizlilik Politikası - Gazi Social')]
class Privacy extends Component
{
    public function render()
    {
        return view('livewire.docs.terms.privacy');
    }
}
