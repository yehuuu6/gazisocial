<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class SearchPost extends Component
{

    use WithPagination;

    public $query = '';

    public function render()
    {
        return view('livewire.pages.posts.search-post', [
            'posts' => Post::with(['user'])
                ->withCount('comments')
                ->where('title', 'like', '%' . $this->query . '%')
                ->orWhere('content', 'like', '%' . $this->query . '%')
                ->latest('created_at')
                ->simplePaginate(10),
        ])->title($this->query . ' için arama sonuçları - ' . config('app.name'));
    }
}
