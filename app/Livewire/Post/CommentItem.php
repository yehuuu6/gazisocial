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
use Livewire\Attributes\Renderless;
use Masmerise\Toaster\Toaster;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class CommentItem extends Component
{
    use WithRateLimiting;

    public Comment $comment;
    public Post $post;

    public $content;

    public int $initialMaxReplyCount;
    public int $maxReplyCount;
    public int $replyIncrementCount; // The number of replies to show when the user clicks the "Load more replies" button.

    public bool $isSingleCommentThread;
    public $renderedReplyId;
    public bool $replyForm; // Reply form visibility

    public int $depth;

    public bool $isLiked = false;
    public int $likesCount;

    public bool $isAuthenticated;

    public function mount(bool $isSingleCommentThread = false, int $depth = 0, $renderedReplyId = null): void
    {
        $this->isSingleCommentThread = $isSingleCommentThread;

        $this->setInitialMaxReplyCount();

        $this->depth = $depth;
        $this->comment->depth = $depth;

        $this->setMaxRenderedReplyCount();

        $this->renderedReplyId = $renderedReplyId;

        $this->isLiked = $this->comment->isLiked();
        $this->likesCount = $this->comment->likes_count;

        $this->isAuthenticated = Auth::check();
    }

    /**
     * Load more replies.
     * This method is called when the user clicks the "Load more replies" button.
     * It increases the maxReplyCount by the replyIncrementCount.
     * @param int $moreReplyCount The number of replies to load. Comes from frontend.
     */
    public function loadMoreReplies(int $moreReplyCount): void
    {
        // If the moreReplyCount is less than the replyIncrementCount,
        // just load the moreReplyCount.
        // This is to prevent loading more replies than the actual number of replies.
        if ($moreReplyCount < $this->replyIncrementCount) {
            $this->maxReplyCount += $moreReplyCount;
        } else {
            $this->maxReplyCount += $this->replyIncrementCount;
        }
    }

    private function setInitialMaxReplyCount()
    {
        // If it's not a single comment thread, we will show 5 replies.

        if (!$this->isSingleCommentThread) {
            $this->initialMaxReplyCount = 5;
        } else {
            // If it's a single comment thread, we will show 10 replies.
            $this->initialMaxReplyCount = 10;
        }
    }

    private function setMaxRenderedReplyCount(): void
    {
        $this->maxReplyCount = $this->initialMaxReplyCount;

        if ($this->comment->depth > 5) {
            // If the depth is greater than 5, we will show 1 less reply on each level.
            // So, if the depth is 6, we will show 4, if the depth is 7, we will show 3, and so on.
            // The result is negative, so we multiply it by -1 to get the positive value.
            $this->maxReplyCount = (($this->comment->depth - 5) - $this->initialMaxReplyCount) * -1;
        }

        // Set the replyIncrementCount to the maxReplyCount.
        $this->replyIncrementCount = $this->maxReplyCount;
    }

    #[Renderless]
    public function toggleLike()
    {

        if (!Auth::check()) {
            $this->dispatch('auth-required');
            return;
        }

        try {
            $this->rateLimit(50, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            $this->dispatch('blocked-from-liking');
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        // Check if the comment is liked by the user.

        if ($this->comment->isLiked()) {
            $response = Gate::inspect('delete', [Like::class, $this->comment]);
            if (!$response->allowed()) {
                Toaster::error('Bu işlemi yapmak için yetkiniz yok.');
                return;
            }
        } else {
            $response = Gate::inspect('create', [Like::class, $this->comment]);
            if (!$response->allowed()) {
                Toaster::error('Bu işlemi yapmak için yetkiniz yok.');
                return;
            }
        }

        $this->comment->toggleLike();
    }

    public function placeholder()
    {
        return view('components.post.comment-placeholder', [
            'depth' => $this->comment->depth
        ]);
    }

    public function createNotification(string $url): void
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
                    'action_url' => $url,
                    'post_id' => $this->post->id,
                    'text' => Auth::user()->name . ' yorumunuza yanıt verdi'
                ],
            ]
        );

        broadcast(new NotificationReceived(receiver: $this->comment->user))->toOthers();
    }

    private function limitLineBreaks(string $text, int $maxBreaks = 3): string
    {
        // Replace multiple line breaks with a placeholder
        $parts = preg_split('/(\r\n|\r|\n)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

        $count = 0;
        $result = '';

        foreach ($parts as $part) {
            if (preg_match('/\r\n|\r|\n/', $part)) {
                $count++;
                if ($count > $maxBreaks) {
                    continue; // Skip extra line breaks
                }
            }
            $result .= $part;
        }

        return $result;
    }

    private function handleReplyCreation(?string $content = null, ?string $gifUrl = null)
    {
        if (!Auth::check()) {
            $this->dispatch('auth-required');
            return false;
        }

        $response = Gate::inspect('create', Comment::class);

        if (!$response->allowed()) {
            Toaster::warning('Yorum yapmak için onaylı bir hesap gereklidir.');
            return false;
        }

        if ($content) {
            $content = $this->limitLineBreaks($content);

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
                $replyData = [...$validated];
            } catch (ValidationException $e) {
                Toaster::error($e->validator->errors()->first());
                return false;
            }
        } else {
            $replyData = [];
        }

        if ($gifUrl) {
            $replyData['gif_url'] = $gifUrl;
        }

        $parentId = $this->comment->parent_id ?? $this->comment->id;

        $replyData = [
            ...$replyData,
            'post_id' => $this->post->id,
            'parent_id' => $parentId,
            'user_id' => Auth::id(),
            'commentable_id' => $this->comment->id,
            'commentable_type' => $this->comment->getMorphClass(),
            'depth' => $this->comment->depth + 1
        ];

        $reply = $this->comment->replies()->create($replyData);

        $this->createNotification($this->comment->showRoute(['reply' => $reply->id]));
        Toaster::success('Yorumunuz başarıyla eklendi.');
        $this->dispatch("view-replies.{$this->comment->id}");
        $this->dispatch('comment-added');
        $this->replyForm = false;
        $this->reset('content');

        return true;
    }

    public function sendGif(string $gifUrl)
    {
        return $this->handleReplyCreation(gifUrl: $gifUrl);
    }

    public function addReply()
    {
        return $this->handleReplyCreation($this->content);
    }

    public function deleteComment(Comment $comment)
    {
        $response = Gate::inspect('delete', $comment);

        if (!$response->allowed()) {
            Toaster::error('Bu işlemi yapmak için yetkiniz yok.');
            return;
        }

        // Rate limit the delete action

        try {
            $this->rateLimit(30, decaySeconds: 1200);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        $countToDecrease = $comment->getAllRepliesCount() + 1; // Add 1 to include the comment itself

        if ($comment->user_id === Auth::id()) {
            // Update user's last activity
            $comment->user->heartbeat();
        }

        $comment->delete();

        Toaster::info('Yorum silindi.');

        $this->dispatch('comment-deleted', decreaseCount: $countToDecrease);
    }

    public function render()
    {
        $this->comment->loadCount('replies');

        $this->comment->depth = $this->depth;

        return view('livewire.post.comment-item');
    }
}
