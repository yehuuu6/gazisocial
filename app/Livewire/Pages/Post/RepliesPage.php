<?php

namespace App\Livewire\Pages\Post;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RepliesPage extends Component
{

    use WithPagination, WithoutUrlPagination;

    public Post $post;
    public Comment $comment;
    public $postAuthor;

    public ?Reply $latestCreatedReply = null;

    public function mount()
    {
        $this->postAuthor = $this->post->user->id;
    }

    public function getNewlyAddedReplyByUser()
    {
        // Fetch the latest reply by the user in the last 5 seconds
        $latestReply = $this->comment->replies()
            ->where('user_id', Auth::id())
            ->where('created_at', '>=', now()->subSeconds(5))
            ->latest('created_at')
            ->first();

        if ($latestReply) {
            $this->latestCreatedReply = $latestReply;
        } else {
            $this->latestCreatedReply = null;
        }
    }

    #[On('reply-added')]
    #[On('reply-deleted')]
    public function render()
    {
        $this->getNewlyAddedReplyByUser();

        return view('livewire.pages.post.replies-page', [
            'replies' => $this->comment->replies()->with(['user', 'likes'])->oldest('created_at')->simplePaginate(20),
        ]);
    }
}
