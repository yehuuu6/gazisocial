<?php

namespace App\Livewire\Docs\Terms;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Kullanıcı Sözleşmesi - Gazi Social')]
class UserTerms extends Component
{
    public function render()
    {
        return view('livewire.docs.terms.user-terms');
    }
}
