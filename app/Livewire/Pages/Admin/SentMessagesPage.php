<?php

namespace App\Livewire\Pages\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ContactMessage;
use Livewire\Attributes\Title;

#[Title('Gönderilen Mesajlar - Gazi Social Yönetici')]
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
