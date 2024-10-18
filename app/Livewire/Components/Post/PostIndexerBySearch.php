<?php

namespace App\Livewire\Components\Post;

use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class PostIndexerBySearch extends Component
{

    use WithPagination;

    public $query;
    public $tag;

    public function placeholder()
    {
        return view('components.posts.placeholder');
    }

    public function mount()
    {
        // If query is empty, redirect to home page
        if (empty($this->query)) return redirect()->to(route('home'));
    }

    public function getOrderType(): string
    {
        // Get the order type from session(order)
        return session('order', 'created_at');
    }

    public function updatingPage()
    {
        $this->dispatch('scroll-to-top');
    }

    public function fetchPosts()
    {
        if ($this->tag === 'all') {
            $posts = Post::with(['user'])
                ->with('tags')
                ->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->query . '%')
                        ->orWhere('content', 'like', '%' . $this->query . '%');
                })
                ->when($this->getOrderType() === 'popularity', function ($query) {
                    $timePeriod = session('time_period', 'today');
                    switch ($timePeriod) {
                        case 'today':
                            $query->whereDate('posts.created_at', today());
                            break;
                        case 'one_week':
                            $query->whereBetween('posts.created_at', [now()->subWeek(), now()]);
                            break;
                        case 'three_months':
                            $query->whereBetween('posts.created_at', [now()->subMonths(3), now()]);
                            break;
                        case 'six_months':
                            $query->whereBetween('posts.created_at', [now()->subMonths(6), now()]);
                            break;
                        case 'one_year':
                            $query->whereBetween('posts.created_at', [now()->subYear(), now()]);
                            break;
                        case 'all_time':
                            break;
                    }
                })
                ->latest($this->getOrderType())
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
                ->when($this->getOrderType() === 'popularity', function ($query) {
                    $timePeriod = session('time_period', 'today');
                    switch ($timePeriod) {
                        case 'today':
                            $query->whereDate('posts.created_at', today());
                            break;
                        case 'one_week':
                            $query->whereBetween('posts.created_at', [now()->subWeek(), now()]);
                            break;
                        case 'three_months':
                            $query->whereBetween('posts.created_at', [now()->subMonths(3), now()]);
                            break;
                        case 'six_months':
                            $query->whereBetween('posts.created_at', [now()->subMonths(6), now()]);
                            break;
                        case 'one_year':
                            $query->whereBetween('posts.created_at', [now()->subYear(), now()]);
                            break;
                        case 'all_time':
                            break;
                    }
                })
                ->latest($this->getOrderType())
                ->simplePaginate(20);
        }

        return $posts;
    }

    #[On('orderChanged')]
    #[On('time-period-updated')]
    public function handleEvents()
    {
        $this->goFirstPage();
        $this->render();
    }

    public function goFirstPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.components.post.post-indexer-by-search', [
            'posts' => $this->fetchPosts(),
        ])->title($this->query . ' için arama sonuçları - ' . config('app.name'));
    }
}
