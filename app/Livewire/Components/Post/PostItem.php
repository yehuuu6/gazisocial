<?php

namespace App\Livewire\Components\Post;

use App\Models\Post;
use Livewire\Component;

class PostItem extends Component
{

    public Post $post;

    public function mount()
    {

        if ($this->post->is_anon && !$this->post->anonToMe()) {
            $this->post->user->name = 'Anonim';
            $this->post->user->avatar = 'https://ui-avatars.com/api/?name=Anonymous&color=7F9CF5&background=EBF4FF';
            $this->post->user->username = 'anonymous';
        }
    }

    public function getTagColor(string $color)
    {
        return "bg-$color-500";
    }

    public function render()
    {
        return view('livewire.components.post.post-item');
    }
}
