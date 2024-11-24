<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ContactMessage;

class SentMessagesPage extends Component
{

    use WithPagination;

    public function render()
    {
        return view('livewire.pages.admin.sent-messages-page', [
            'messages' => ContactMessage::latest()->simplePaginate(10)
        ]);
    }
}
