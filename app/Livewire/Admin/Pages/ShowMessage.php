<?php

namespace App\Livewire\Admin\Pages;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Kullanıcı Mesajı - Gazi Social Yönetici')]
class ShowMessage extends Component
{

    public ContactMessage $message;

    public function render()
    {
        return view('livewire.admin.pages.show-message');
    }
}
