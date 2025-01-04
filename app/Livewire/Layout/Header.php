<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\On;

class Header extends Component
{
    public $class = 'text-gray-700 bg-white';
    public $text = 'Etiketler';
    public $slug;

    public function mount()
    {
        if (Request::is('tags/*')) {
            $this->slug = explode('/', Request::path())[1];
            $this->text = optional(\App\Models\Tag::where('slug', $this->slug)->first())->name ?? $this->text;
            $this->class = 'text-primary bg-blue-100';
        } elseif (Request::is('posts/search/*')) {
            $this->slug = explode('/', Request::path())[2];

            if ($this->slug !== 'all') {
                $this->text = optional(\App\Models\Tag::where('slug', $this->slug)->first())->name ?? $this->text;
                $this->class = 'text-primary bg-blue-100';
            }
        }
    }

    #[On('orderChanged')]
    public function render()
    {
        return view('livewire.layout.header');
    }
}
