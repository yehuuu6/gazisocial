<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use Livewire\Component;
use Livewire\Attributes\Computed;

class TagsLister extends Component
{
    #[Computed(cache: false)]
    public function tags()
    {
        return Tag::all('slug', 'name', 'color', 'id');
    }

    public function test()
    {
        unset($this->tags);
    }

    // Not used if not lazy loading
    public function placeholder()
    {
        return view('components.tag.tag-placeholder');
    }
}
