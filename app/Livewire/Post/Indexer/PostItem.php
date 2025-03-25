<?php

namespace App\Livewire\Post\Indexer;

use App\Models\Post;
use Livewire\Component;

class PostItem extends Component
{
    public Post $post;
    
    // Property to determine if pins should be shown
    public bool $show_pins = false;

    public function render()
    {
        return view('livewire.post.indexer.post-item');
    }
}
