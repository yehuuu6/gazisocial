<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class HomePage extends Component
{

    use WithPagination;

    public function updatingPage()
    {
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.pages.home-page', [
            'posts' => Post::with('user')->latest()->simplePaginate(10)
        ]);
    }
}
