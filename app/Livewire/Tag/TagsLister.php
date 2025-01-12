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

    // Can't access the request() function in this component
    // because it's lazy loaded so it thinks that the route is livewire/update
    // and not the route that we are currently in.
    // If we give the route data from the header component (which is not a livewire component)
    // it will work, but if the route is different than the tags route
    // and by that I mean if the current request does not have a tag parameter,
    // then the page gives a 404 modal error.
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
