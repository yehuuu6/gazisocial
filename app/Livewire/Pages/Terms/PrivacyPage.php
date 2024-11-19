<?php

namespace App\Livewire\Pages\Terms;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Gizlilik Politikası - Gazi Social')]
class PrivacyPage extends Component
{
    public function render()
    {
        return view('livewire.pages.terms.privacy-page');
    }
}
