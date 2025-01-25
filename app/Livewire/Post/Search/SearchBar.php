<?php

namespace App\Livewire\Post\Search;

use App\Models\Post;
use Livewire\Component;

class SearchBar extends Component
{
    public string $search = '';

    public function getSearchResults()
    {
        if (strlen($this->search) < 3) {
            return collect();
        }
        return Post::search($this->search)->take(5)->get();
    }

    public function render()
    {
        return view('livewire.post.search.search-bar', [
            'posts' => $this->getSearchResults()
        ]);
    }
}
