<?php

namespace App\Livewire\Post\Pages;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class SingleCommentThread extends Component
{
    use LivewireAlert, WithRateLimiting;

    public Post $post;
    public int $selectedCommentId;

    public function mount(Post $post, int $selectedCommentId)
    {
        $this->post = $post;
        $this->selectedCommentId = $selectedCommentId;
    }

    public function redirectAuth(string $route)
    {
        // Redirect to the login page with the intended route
        return redirect()->setIntendedUrl($this->post->showRoute())->route($route);
    }

    public function placeholder()
    {
        return view('components.post.comment-list-placeholder');
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
