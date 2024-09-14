<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class SearchPost extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $query = '';

    public function mount($query = '')
    {
        $this->query = $query;

        // If query is empty, redirect to home page
        if (empty($this->query)) return redirect()->to(route('home'));
    }

    public function updatingPage()
    {
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.pages.posts.search-post', [
            'posts' => Post::with(['user'])
                ->with('tags')
                ->withCount('comments')
                ->where('title', 'like', '%' . $this->query . '%')
                ->orWhere('content', 'like', '%' . $this->query . '%')
                ->latest('created_at')
                ->simplePaginate(10),
        ])->title($this->query . ' için arama sonuçları - ' . config('app.name'));
    }
}
