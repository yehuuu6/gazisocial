<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class SearchPost extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $query;
    public $category;

    public function mount($query, $category)
    {
        $this->query = $query;
        $this->category = $category;

        // If query is empty, redirect to home page
        if (empty($this->query)) return redirect()->to(route('home'));
    }

    public function updatingPage()
    {
        $this->dispatch('scroll-to-top');
    }

    public function getPosts()
    {
        if ($this->category === 'all') {
            $posts = Post::with(['user'])
                ->with('tags')
                ->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->query . '%')
                        ->orWhere('content', 'like', '%' . $this->query . '%');
                })
                ->latest('created_at')
                ->simplePaginate(10);
        } else {
            $tag = Tag::where('name', $this->category)->first();
            $posts = $tag
                ->posts()
                ->with(['user'])
                ->with('tags')
                ->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->query . '%')
                        ->orWhere('content', 'like', '%' . $this->query . '%');
                })
                ->latest('created_at')
                ->simplePaginate(10);
        }

        return $posts;
    }

    public function render()
    {
        return view('livewire.pages.posts.search-post', [
            'posts' => $this->getPosts(),
        ])->title($this->query . ' için arama sonuçları - ' . config('app.name'));
    }
}
