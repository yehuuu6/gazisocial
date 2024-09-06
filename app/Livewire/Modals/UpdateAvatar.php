<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\User;

class UpdateAvatar extends ModalComponent
{

    use LivewireAlert;

    public function render()
    {
        return view('livewire.modals.update-avatar');
    }
}
