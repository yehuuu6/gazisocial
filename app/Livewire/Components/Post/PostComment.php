<?php

namespace App\Livewire\Components\Post;

use App\Models\Like;
use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Database\Eloquent\Relations\Relation;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class PostComment extends Component
{

    use LivewireAlert, WithRateLimiting;

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
        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

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
