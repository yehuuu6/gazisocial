<?php

namespace App\Livewire\Post\Search;

use App\Models\Post;
use App\Models\Tag;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SearchBar extends Component
{
    public string $search = '';

    #[Computed(persist: true)]
    public function tags()
    {
        // Get most popular 4 tags
        return Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(4)->get();
    }

    public function resetSearch()
    {
        $this->reset();
    }

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
