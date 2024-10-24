<?php

namespace App\Livewire\Modals;

use Livewire\Component;
use App\Models\Post;

class ShareModal extends Component
{
    public $url;

    public function render()
    {
        return view('livewire.modals.share-modal');
    }
}
