<?php

namespace App\Livewire\Pages\Dev;

use Livewire\Component;
use App\Models\ReportedBug as Bug;

class ShowBug extends Component
{

    public Bug $bug;

    public function render()
    {
        return view('livewire.pages.dev.show-bug');
    }
}
