<?php

namespace App\Livewire\Pages\Post;

use App\Models\Comment;
use App\Models\Post;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\Component;

class RepliesPage extends Component
{

    use WithPagination, WithoutUrlPagination;

    public Post $post;
    public Comment $comment;
    public $postAuthor;

    public function mount()
    {
        $this->postAuthor = $this->post->user->id;
    }

    #[On('reply-added')]
    #[On('reply-deleted')]
    public function render()
    {
        $this->comment->load('replies.user', 'replies.likes');
        return view('livewire.pages.post.replies-page', [
            'replies' => $this->comment->replies()->with(['user', 'likes'])->oldest('created_at')->simplePaginate(20),
        ]);
    }
}
