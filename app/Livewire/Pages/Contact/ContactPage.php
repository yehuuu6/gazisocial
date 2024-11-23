<?php

namespace App\Livewire\Pages\Contact;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('İletişime geç - Gazi Social')]
class ContactPage extends Component
{
    public function render()
    {
        return view('livewire.pages.contact.contact-page');
    }
}
