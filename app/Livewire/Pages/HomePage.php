<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class HomePage extends Component
{
    use WithPagination;

    public string $order = 'latest';

    public function getOrderType(): string
    {
        $orderDefinitions = [
            '' => 'created_at',
            'latest' => 'created_at',
            'popular' => 'comments_count',
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
            ->select('id', 'user_id', 'title', 'content', 'created_at')
            ->with('user:id,name,avatar,username')
            ->with('tags:id,name')
            ->withCount('comments')
            ->latest($this->getOrderType())
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.pages.home-page', [
            'posts' => $this->fetchPosts(),
        ]);
    }
}
