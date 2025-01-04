<?php

namespace App\Livewire\Docs;

use Livewire\Component;
use App\Models\ReportedBug as Bug;

class ShowBug extends Component
{

    public Bug $bug;

    public function render()
    {
        return view('livewire.docs.show-bug');
    }
}
