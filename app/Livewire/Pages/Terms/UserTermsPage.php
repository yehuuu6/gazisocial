<?php

namespace App\Livewire\Pages\Terms;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Kullanıcı Sözleşmesi - Gazi Social')]
class UserTermsPage extends Component
{
    public function render()
    {
        return view('livewire.pages.terms.user-terms-page');
    }
}
