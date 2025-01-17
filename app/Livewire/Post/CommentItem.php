<?php

namespace App\Livewire\Post;

use App\Events\NotificationReceived;
use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class CommentItem extends Component
{
    use LivewireAlert, WithRateLimiting;

    public Comment $comment;
    public Post $post;

    public $content;

    public int $initialMaxReplyCount = 5;
    public int $maxReplyCount;

    public bool $isLiked = false;
    public int $likesCount;

    public bool $isAuthenticated;

    public function mount()
    {
        if ($this->comment->depth <= 5) {
            // If the depth is less than or equal to 5, we will show 5 replies.
            $this->maxReplyCount = $this->initialMaxReplyCount;
        } else {
            // If the depth is greater than 5, we will show 1 less reply on each level.
            // So, if the depth is 6, we will show 4, if the depth is 7, we will show 3, and so on.
            // The result is negative, so we multiply it by -1 to get the positive value.
            $this->maxReplyCount = (($this->comment->depth - 5) - $this->initialMaxReplyCount) * -1;
        }

        $this->isLiked = $this->comment->isLiked();
        $this->likesCount = $this->comment->likes_count;

        $this->isAuthenticated = Auth::check();
    }

    public function toggleLike()
    {

        if (!Auth::check()) {
            $this->dispatch('auth-required', msg: 'Yorumları beğenebilmek için');
            return;
        }

        try {
            $this->rateLimit(50, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            $this->dispatch('blocked-from-liking');
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        // Check if the comment is liked by the user.

        if ($this->comment->isLiked()) {
            $response = Gate::inspect('delete', [Like::class, $this->comment]);
            if (!$response->allowed()) {
                $this->alert('error', 'Bu işlemi yapmak için yetkiniz yok.');
                return;
            }
        } else {
            $response = Gate::inspect('create', [Like::class, $this->comment]);
            if (!$response->allowed()) {
                $this->alert('error', 'Bu işlemi yapmak için yetkiniz yok.');
                return;
            }
        }

        $this->comment->toggleLike();
    }

    public function placeholder()
    {
        return view('components.post.comment-placeholder');
    }

    public function createNotification(int $replyId): void
    {

        if ($this->comment->user_id === Auth::id()) {
            return;
        }

        Notification::create(
            [
                'user_id' => $this->comment->user_id,
                'type' => 'comment_reply',
                'data' => [
                    'sender_id' => Auth::id(),
                    'comment_id' => $this->comment->id,
                    'reply_id' => $replyId,
                    'post_id' => $this->post->id,
                    'text' => Auth::user()->name . ' yorumunuza yanıt verdi'
                ],
            ]
        );

        broadcast(new NotificationReceived(receiver: $this->comment->user))->toOthers();
    }

    public function addReply()
    {

        if (!Auth::check()) {
            $this->dispatch('auth-required', msg: 'Yanıt yazabilmek için');
            return;
        }

        $response = Gate::inspect('create', Comment::class);

        if (!$response->allowed()) {
            $this->alert('error', 'Yorum yapmak e-posta onaylı bir hesap gerektirir.');
            return;
        }

        /*
        try {
            $this->rateLimit(50, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }
        */

        $messages = [
            'required' => 'Yorum içeriği boş olamaz.',
            'min' => 'Yorum içeriği en az :min karakter olmalıdır.',
            'max' => 'Yorum içeriği en fazla :max karakter olabilir.',
            'string' => 'Yorum içeriği metin olmalıdır.',
        ];

        try {
            $validated = $this->validate([
                'content' => 'required|string|min:3|max:1000',
            ], $messages);
        } catch (ValidationException $e) {
            $this->alert('error', $e->getMessage());
            return;
        }

        $parentId = $this->comment->parent_id ?? $this->comment->id;

        $reply = $this->comment->replies()->create([
            ...$validated,
            'post_id' => $this->post->id,
            'parent_id' => $parentId,
            'user_id' => Auth::id(),
            'commentable_id' => $this->comment->id,
            'commentable_type' => $this->comment->getMorphClass(),
            'depth' => $this->comment->depth + 1
        ]);

        $this->createNotification($reply->id);

        $this->alert('success', 'Yanıtınız başarıyla eklendi.');

        $this->dispatch("view-replies.{$this->comment->id}");

        $this->dispatch('comment-added');

        $this->reset('content');
    }

    public function deleteComment(Comment $comment)
    {
        $response = Gate::inspect('delete', $comment);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu yorumu silme izniniz yok.');
            return;
        }

        // Rate limit the delete action

        try {
            $this->rateLimit(30, decaySeconds: 1200);
        } catch (TooManyRequestsException $exception) {
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        $countToDecrease = $comment->getAllRepliesCount() + 1; // Add 1 to include the comment itself

        if ($comment->user_id === Auth::id()) {
            // Update user's last activity
            $comment->user->heartbeat();
        }

        $comment->delete();

        $this->alert('success', 'Yorum başarıyla silindi.');

        $this->dispatch('comment-deleted', decreaseCount: $countToDecrease);
    }

    public function render()
    {
        $this->comment->loadCount('replies');

        return view('livewire.post.comment-item');
    }
}
