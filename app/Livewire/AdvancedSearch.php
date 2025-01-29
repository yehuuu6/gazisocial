<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use App\Models\Post;
use App\Models\Tag;

class AdvancedSearch extends Component
{

    #[Url(as: 'q')]
    public string $search = '';

    public array $selectedTags = [];

    public function clearSearch()
    {
        $this->search = '';
    }

    // Dummy method to show loading on button click
    public function searchPosts()
    {
        $this->search = $this->search;
        $this->dispatch('scroll-to-results')->self();
    }

    #[Computed(cache: true)]
    public function tags()
    {
        return Tag::all();
    }

    #[Computed]
    public function posts()
    {
        if (empty($this->search) || strlen($this->search) < 3) {
            return collect();
        }

        // Fetch posts and eager load the tags relationship
        $posts = Post::search($this->search)->take(10)->get()->load('tags', 'user');

        if (!empty($this->selectedTags)) {
            $posts = $posts->filter(function ($post) {
                return $post->tags->pluck('id')->intersect($this->selectedTags)->isNotEmpty();
            });
        }

        return $posts;
    }


    public function render()
    {
        return view('livewire.advanced-search')->title('Gelişmiş arama - Gazi Social');
    }
}
