<?php

namespace App\Livewire\Components\Post;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\Relation;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Like;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class CommentReply extends Component
{

    use LivewireAlert, WithRateLimiting;

    public $reply;
    public $isNew = false;
    public $type = 'nested'; // To render border-left on nested replies. Might be full-page or nested.
    public bool $isAuthor = false;
    public bool $isAnonPost = false;

    public function mount()
    {
        $this->isAnonPost = $this->reply->post()->where('user_id', $this->reply->user_id)->where('is_anon', true)->exists();
        if (! $this->isAnonPost) {
            $this->isAuthor = $this->reply->post()->where('user_id', $this->reply->user_id)->exists();
        }
    }

    public function isLikedByUser(): bool
    {
        return $this->reply->likes()->where('user_id', Auth::id())->exists();
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

            $this->authorize('create', [Like::class, $this->reply]);

            $likeable = Relation::getMorphedModel('reply')::findOrFail($this->reply->id);

            $likeable->likes()->create([
                'user_id' => Auth::id(),
            ]);

            $msg = 'Yanıt beğenildi.';
        } else {

            $this->authorize('delete', [Like::class, $this->reply]);

            $this->reply->likes()->whereBelongsTo(Auth::user())->delete();
            $this->reply->decrement('likes_count');
            $msg = 'Yanıt beğenisi kaldırıldı.';
        }

        $this->alert('success', $msg);

        $this->reply->refresh();
    }

    public function render()
    {
        return view('livewire.components.post.comment-reply');
    }
}
