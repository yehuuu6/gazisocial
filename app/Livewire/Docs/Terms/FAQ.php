<?php

namespace App\Livewire\Docs\Terms;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Sıkça Sorulan Sorular - Gazi Social')]
class FAQ extends Component
{
    public function render()
    {
        return view('livewire.docs.terms.f-a-q');
    }
}
