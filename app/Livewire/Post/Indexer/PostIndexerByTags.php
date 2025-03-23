<?php

namespace App\Livewire\Post\Indexer;

use App\Models\Tag;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Traits\OrderByManager;

class PostIndexerByTags extends Component
{
    use WithPagination, OrderByManager;

    public Tag $tag;

    public string $order;

    #[Url(as: 'time')]
    public string $timeSpan = 'all';

    private function validateTimeSpan(string $spanToValidate)
    {
        return in_array($spanToValidate, ['today', 'this_week', 'this_month', 'six_months', 'one_year', 'all']);
    }

    public function mount(Tag $tag, string $order)
    {
        if (!$this->validateTimeSpan($this->timeSpan)) {
            $this->timeSpan = 'all';
        }

        $this->tag = $tag;
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
        $query = Post::with('user', 'tags')
            ->whereHas('tags', function ($query) {
                $query->where('tags.id', $this->tag->id);
            });

        // Apply time span filter
        if ($this->timeSpan && $this->timeSpan !== 'all') {
            $query->where('created_at', '>=', $this->getTimeSpanDate());
        }

        return $query
            ->orderBy('is_pinned', 'desc')
            ->orderBy($this->getSqlTerminology($this->order), 'desc')
            ->simplePaginate(20);
    }

    public function updatedPage($page)
    {
        $this->dispatch('scroll-to-top');
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
        return view('livewire.post.indexer.post-indexer-by-tags');
    }
}
