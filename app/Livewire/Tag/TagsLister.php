<?php

namespace App\Livewire\Tag;

use App\Models\Tag;
use Livewire\Component;
use Livewire\Attributes\Computed;

class TagsLister extends Component
{
    public ?string $displayName = null;
    public ?string $displayColor = null;

    #[Computed(cache: true)]
    public function tags()
    {
        return Tag::all();
    }

    public function mount()
    {
        $this->displayName = $this->displayName ? $this->displayName : 'Etiketler';
        $this->displayColor = $this->displayColor ? "border-l-4 border-$this->displayColor-500" : '';
    }

    public function placeholder()
    {
        return view('components.tag.tag-placeholder');
    }
}
