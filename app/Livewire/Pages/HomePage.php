<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

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
        return Post::query()
            ->with('user')
            ->with('tags')
            ->latest($this->getOrderType())
            ->simplePaginate(20);
    }

    #[On('orderChanged')]
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
