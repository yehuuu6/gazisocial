<?php

namespace App\Livewire\Components;

use App\Models\Tag;
use Livewire\Component;

class Categories extends Component
{

    public function render()
    {
        return view('livewire.components.categories', [
            'tags' => Tag::all()
        ]);
    }
}
