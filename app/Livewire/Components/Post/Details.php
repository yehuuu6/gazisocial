<?php

namespace App\Livewire\Components\Post;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\On;

class Details extends Component
{

    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post->loadCount('comments');
    }

    #[On('comment-created')]
    #[On('comment-deleted')]
    public function refreshPage()
    {
        $this->post->refresh();
    }

    public function render()
    {
        return view('livewire.components.post.details');
    }
}
