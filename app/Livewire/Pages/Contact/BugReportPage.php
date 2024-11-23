<?php

namespace App\Livewire\Pages\Contact;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Hata bildir - Gazi Social')]
class BugReportPage extends Component
{
    public function render()
    {
        return view('livewire.pages.contact.bug-report-page');
    }
}
