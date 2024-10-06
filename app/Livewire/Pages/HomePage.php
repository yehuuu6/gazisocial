<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class HomePage extends Component
{
    use WithPagination, LivewireAlert;

    public string $order = 'latest';

    public function getOrderType(): string
    {
        $orderDefinitions = [
            '' => 'created_at',
            'latest' => 'created_at',
            'popular' => 'popularity',
        ];

        if (!array_key_exists($this->order, $orderDefinitions)) abort(404);

        return $orderDefinitions[$this->order];
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
