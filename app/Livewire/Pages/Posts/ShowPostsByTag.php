<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Tag;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Component;
use Livewire\Attributes\On;

class ShowPostsByTag extends Component
{

    use WithPagination, WithoutUrlPagination;

    public Tag $tag;

    public function getOrderType(): string
    {
        // Get the order type from session(order)
        return session('order', 'created_at');
    }

    #[On('orderChanged')]
    public function render()
    {
        return view('livewire.pages.posts.show-posts-by-tag', [
            'posts' => $this->tag->posts()
                ->with('user')
                ->with('tags')
                ->latest($this->getOrderType())
                ->simplePaginate(20)
        ]);
    }
}
