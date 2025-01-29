<?php

namespace App\Livewire\Post\Pages;

use App\Models\Tag;
use App\Traits\OrderByManager;
use Livewire\Component;

class ListPostsByTag extends Component
{
    use OrderByManager;

    public Tag $tag;
    public string $order;

    public function mount(string $order = 'latest')
    {
        $this->validateOrderType($order);
        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.post.pages.list-posts-by-tag');
    }
}
