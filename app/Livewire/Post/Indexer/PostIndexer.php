<?php

namespace App\Livewire\Post\Indexer;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use App\Traits\OrderByManager;

class PostIndexer extends Component
{
    use WithPagination, OrderByManager;

    public string $order;
    #[Url(as: 'time')]
    public string $timeSpan = 'all';

    private function validateTimeSpan(string $spanToValidate)
    {
        return in_array($spanToValidate, ['today', 'this_week', 'this_month', 'six_months', 'one_year', 'all']);
    }

    public function mount(string $order)
    {
        if (!$this->validateTimeSpan($this->timeSpan)) {
            $this->timeSpan = 'all';
        }
        // No need for validation here because it was already done in the parent component
        $this->order = $order;
    }

    #[On('time-span-selected')]
    public function updateTimeSpan(string $timeSpan)
    {
        // Update the popular posts time span
        $this->timeSpan = $timeSpan;
    }

    #[Computed]
    public function posts()
    {
        $query = Post::with('user', 'tags');

        // Apply time span filter
        if ($this->timeSpan && $this->timeSpan !== 'all') {
            $query->where('created_at', '>=', $this->getTimeSpanDate());
        }

        // Order by latest or popularity
        return $query
            ->orderBy($this->getSqlTerminology($this->order), 'desc')
            ->simplePaginate(20);
    }

    // Helper function to determine time range
    private function getTimeSpanDate()
    {
        return match ($this->timeSpan) {
            'today' => now()->subDay(),
            'this_week' => now()->subWeek(),
            'this_month' => now()->subMonth(),
            'six_months' => now()->subMonths(6),
            'one_year' => now()->subYear(),
            default => null,
        };
    }

    public function placeholder()
    {
        return view('components.post.indexer-placeholder');
    }

    public function render()
    {
        return view('livewire.post.indexer.post-indexer');
    }
}
