<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Post;

class SearchBar extends Component
{
    public $search = '';

    public function render()
    {
        $posts = [];

        if (strlen($this->search) >= 2) {
            $posts = Post::with(['user'])
                ->where('title', 'like', '%' . $this->search . '%' )
                ->orWhere('content', 'like', '%' . $this->search . '%' )
                ->latest()
                ->limit(7)
                ->get();
        }

        return view('livewire.components.search-bar', [
            'posts' => $posts,
        ]);
    }
}
