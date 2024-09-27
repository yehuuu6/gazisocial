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
    public $tag;

    public function mount($query, $tag)
    {
        $this->query = $query;
        $this->tag = $tag;

        // If query is empty, redirect to home page
        if (empty($this->query)) return redirect()->to(route('home'));
    }

    public function updatingPage()
    {
        $this->dispatch('scroll-to-top');
    }

    public function getPosts()
    {
        if ($this->tag === 'all') {
            $posts = Post::with(['user'])
                ->with('tags')
                ->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->query . '%')
                        ->orWhere('content', 'like', '%' . $this->query . '%');
                })
                ->latest('created_at')
                ->simplePaginate(20);
        } else {
            $tag = Tag::where('slug', $this->tag)->first();
            if (!$tag) abort(404);
            $posts = $tag
                ->posts()
                ->with(['user'])
                ->with('tags')
                ->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->query . '%')
                        ->orWhere('content', 'like', '%' . $this->query . '%');
                })
                ->latest('created_at')
                ->simplePaginate(20);
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
