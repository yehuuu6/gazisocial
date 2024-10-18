<?php

namespace App\Livewire\Components\Post;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class PostIndexer extends Component
{
    use WithPagination;

    public function placeholder()
    {
        return view('components.posts.placeholder');
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
        $query = Post::query()
            ->with('user')
            ->with('tags');

        if ($this->getOrderType() === 'popularity') {
            $timePeriod = session('time_period');
            switch ($timePeriod) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'one_week':
                    $query->whereBetween('created_at', [now()->subWeek(), now()]);
                    break;
                case 'three_months':
                    $query->whereBetween('created_at', [now()->subMonths(3), now()]);
                    break;
                case 'six_months':
                    $query->whereBetween('created_at', [now()->subMonths(6), now()]);
                    break;
                case 'one_year':
                    $query->whereBetween('created_at', [now()->subYear(), now()]);
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
        return view('livewire.components.post.post-indexer', [
            'posts' => $this->fetchPosts(),
        ]);
    }
}
