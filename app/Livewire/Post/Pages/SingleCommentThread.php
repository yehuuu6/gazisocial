<?php

namespace App\Livewire\Post\Pages;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Masmerise\Toaster\Toaster;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class SingleCommentThread extends Component
{
    use WithRateLimiting;

    public Post $post;
    public bool $showRegisterModal = false;

    public int $selectedCommentId;
    public $parent; // Post or Comment (commentable)

    public $renderedReplyId;

    public function mount(Post $post, int $selectedCommentId, $renderedReplyId = null)
    {
        $this->post = $post;

        $this->setParent($selectedCommentId);

        $this->renderedReplyId = $renderedReplyId;

        $this->validateReply($renderedReplyId);
    }

    private function validateReply($replyId)
    {
        // If the post does not have a comment with the given id, or the id is null, give an error.
        if ($replyId !== null && Comment::where('id', $replyId)->where('post_id', $this->post->id)->doesntExist()) {
            Toaster::error('Yanıt bulunamadı, silinmiş olabilir.');
        }
    }

    private function setParent(int $selectedCommentId)
    {
        $this->selectedCommentId = $selectedCommentId;
        $mainComment = Comment::findOrFail($selectedCommentId);
        $this->parent = $mainComment->commentable;
    }

    public function redirectAuth(string $route)
    {
        // Redirect to the login page with the intended route
        return redirect()->setIntendedUrl($this->post->showRoute())->route($route);
    }


    protected $listeners = [
        'auth-required' => 'showModal',
    ];

    public function showModal()
    {
        $this->showRegisterModal = true;
    }

    public function placeholder()
    {
        return view('components.post.comment-list-placeholder');
    }

    public function deleteComment(Comment $comment)
    {

        $response = Gate::inspect('delete', $comment);

        if (!$response->allowed()) {
            Toaster::error('Bu yorumu silmek için yetkiniz yok.');
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

        Toaster::success('Yorum başarıyla silindi.');

        $this->dispatch('comment-deleted', decreaseCount: $countToDecrease);
    }

    #[Computed]
    public function comments()
    {
        $comments = Comment::where('post_id', $this->post->id)
            ->where('id', $this->selectedCommentId)
            ->with('user')
            ->withCount('replies')
            ->get();

        return $comments;
    }

    public function render()
    {
        return view('livewire.post.pages.single-comment-thread');
    }
}
