<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Tag;

class MobileCategories extends Component
{
    public function render()
    {
        return view('livewire.components.mobile-categories', [
            'tags' => Tag::all()
        ]);
    }
}
