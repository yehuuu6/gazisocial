<?php

namespace App\Livewire\Components\Post;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ReplyDetails extends Component
{

    public Post $post;
    public Comment $comment;

    public function isLikedByUser(): bool
    {
        return $this->comment->likes->contains('user_id', Auth::id());
    }

    public function render()
    {
        return view('livewire.components.post.reply-details');
    }
}
