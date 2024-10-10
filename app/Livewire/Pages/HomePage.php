<?php

namespace App\Livewire\Pages;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class HomePage extends Component
{
    use WithPagination, LivewireAlert;

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
            $timePeriod = session('time_period', 'today');
            switch ($timePeriod) {
                case 'today':
                    $query->whereDate('created_at', now()->toDateString());
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
    public function render()
    {
        if (session()->has('emailVerified')) {
            $this->alert('success', session('emailVerified'));
        }
        return view('livewire.pages.home-page', [
            'posts' => $this->fetchPosts(),
        ]);
    }
}
