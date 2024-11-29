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

    public string $orderType = 'desc';

    public function sortBy($field)
    {
        if ($this->orderType === 'asc') {
            $this->orderType = 'desc';
        } else {
            $this->orderType = 'asc';
        }
    }

    public function render()
    {
        return view('livewire.pages.admin.sent-messages-page', [
            'messages' => ContactMessage::orderBy('created_at', $this->orderType)->paginate(10),
        ]);
    }
}
