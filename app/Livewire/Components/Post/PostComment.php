<?php

namespace App\Livewire\Components\Post;

use App\Models\Like;
use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Database\Eloquent\Relations\Relation;

class PostComment extends Component
{

    use LivewireAlert;

    public Comment $comment;

    public $replies;

    public function mount()
    {
        $this->setReplies();
        $this->comment->load('post');
    }

    public function isLikedByUser(): bool
    {
        return $this->comment->likes->contains('user_id', Auth::id());
    }

    public function setReplies(): void
    {
        $this->replies = $this->comment->replies()->with(['user', 'likes'])->limit(5)->oldest('created_at')->get();
    }

    public function toggleLike()
    {
        if (! $this->isLikedByUser()) {

            $this->authorize('create', [Like::class, $this->comment]);

            $likeable = Relation::getMorphedModel('comment')::findOrFail($this->comment->id);

            $likeable->likes()->create([
                'user_id' => Auth::id(),
            ]);

            $msg = 'Yorum beğenildi.';
        } else {

            $this->authorize('delete', [Like::class, $this->comment]);
            $comment = $this->comment->likes()->whereBelongsTo(Auth::user())->first();
            $comment->delete();
            $msg = 'Yorum beğenisi kaldırıldı.';
        }

        $this->alert('success', $msg);

        $this->comment->refresh();
    }

    #[On('reply-added')]
    #[On('reply-deleted')]
    public function refreshComment()
    {
        $this->comment->refresh();
        $this->setReplies();
    }

    public function render()
    {
        return view('livewire.components.post.post-comment');
    }
}
