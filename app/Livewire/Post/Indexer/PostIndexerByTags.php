<?php

namespace App\Livewire\Post\Indexer;

use App\Models\Tag;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\On;

class PostIndexerByTags extends Component
{
    use WithPagination;

    public Tag $tag;

    public function getOrderType(): string
    {
        // Get the order type from session(order)
        return session('order', 'created_at');
    }

    public function fetchPosts()
    {
        $query = $this->tag->posts()
            ->with('user', 'tags');

        if ($this->getOrderType() === 'popularity') {
            $timePeriod = session('time_period');
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
        }

        return $query->latest($this->getOrderType())
            ->simplePaginate(20);
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
        return view('livewire.post.indexer.post-indexer-by-tags', [
            'posts' => $this->fetchPosts(),
        ]);
    }
}
