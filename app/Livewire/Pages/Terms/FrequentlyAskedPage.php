<?php

namespace App\Livewire\Pages\Terms;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Sıkça Sorulan Sorular - Gazi Social')]
class FrequentlyAskedPage extends Component
{
    public function render()
    {
        return view('livewire.pages.terms.frequently-asked-page');
    }
}
