<?php

namespace App\Livewire\Admin\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ContactMessage;
use Livewire\Attributes\Title;

#[Title('Gönderilen Mesajlar - Gazi Social Yönetici')]
class MessagesIndexer extends Component
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

        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.pages.messages-indexer', [
            'messages' => ContactMessage::orderBy('created_at', $this->orderType)->paginate(10),
        ]);
    }
}
