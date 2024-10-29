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
            $user = clone $this->post->user;
            $user->name = 'Anonim';
            $user->avatar = 'https://ui-avatars.com/api/?name=Anonymous&color=7F9CF5&background=EBF4FF';
            $user->username = 'anonymous';
            // Hide sensitive fields
            unset($user->email, $user->created_at, $user->updated_at);
            $this->post->user = $user;
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
