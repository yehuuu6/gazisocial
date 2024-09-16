<?php

namespace App\Livewire\Components;

use App\Models\Tag;
use Livewire\Component;

class Categories extends Component
{

    public string $query = '';

    public function render()
    {
        return view('livewire.components.categories', [
            'tags' => Tag::where('name', 'like', '%' . $this->query . '%')->get()
        ]);
    }
}
