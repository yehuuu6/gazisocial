<?php

namespace App\Livewire\Pages\Admin;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Kullanıcı Mesajı - Gazi Social Yönetici')]
class ShowMessagePage extends Component
{

    public ContactMessage $message;

    public function render()
    {
        return view('livewire.pages.admin.show-message-page');
    }
}
