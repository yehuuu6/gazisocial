<?php

namespace App\Livewire\Post\Pages;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Masmerise\Toaster\Toaster;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class ShowPost extends Component
{

    use WithRateLimiting;

    public Post $post;
    public bool $isLiked = false;
    public bool $isSingleCommentThread;
    public $renderedReplyId;
    public $selectedCommentId;
    public int $likesCount;
    public int $commentsCount;

    public bool $isAuthenticated;

    public $colorVariants = [
        'blue' => 'bg-blue-700',
        'red' => 'bg-red-700',
        'green' => 'bg-green-700',
        'yellow' => 'bg-yellow-500',
        'orange' => 'bg-orange-500',
        'purple' => 'bg-purple-500',
    ];

    public function mount(Post $post, Request $request, $comment = null,)
    {
        $this->post = $post;
        $this->controlRoute($request);

        // Set the renredReplyId using the route
        $this->renderedReplyId = request()->query('reply') ?? null;

        $this->isAuthenticated = Auth::check();

        $this->isLiked = $this->post->isLiked();
        $this->likesCount = $this->post->likes_count;
        $this->commentsCount = $this->post->getCommentsCount();

        $this->isSingleCommentThread = $this->determineIfSingleCommentThread($comment);
    }

    private function determineIfSingleCommentThread($comment): bool
    {
        if (! (request()->segment(4) === 'comments' && request()->segment(5) !== null)) {
            return false;
        }
        // If the post does not have a comment with the given ID, return false.
        if (Comment::where('id', $comment)->where('post_id', $this->post->id)->doesntExist()) {
            abort(404);
        }
        if (!is_numeric($comment)) {
            // If the comment is not integer, return false.
            return false;
        }

        $this->selectedCommentId = $comment;

        return true;
    }

    private function controlRoute(Request $request)
    {
        // Segment 1: /p/, Segment 2: post-id, Segment 3: post-slug, Segment 4: /comments/, Segment 5: comment-id
        // If the post slug is not the same as the post slug in the database, redirect to the correct URL.
        $correctSlug = Str::slug($this->post->title);
        if ($request->segment(3) !== $correctSlug) {
            $segments = $request->segments();
            // 0: p, 1: post-id, 2: post-slug, 3: comments, 4: comment-id
            $segments[2] = $correctSlug; // Update third segment with the correct slug
            $correctUrl = implode('/', $segments);
            return redirect()->to($correctUrl, 301);
        }
    }

    public function toggleLike()
    {

        if (!Auth::check()) {
            $this->dispatch('auth-required', msg: 'Gönderileri beğenebilmek için');
            return;
        }

        try {
            $this->rateLimit(50, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            $this->dispatch('blocked-from-liking');
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        // Check if the post is liked by the user.

        if ($this->post->isLiked()) {
            $response = Gate::inspect('delete', [Like::class, $this->post]);
            if (!$response->allowed()) {
                Toaster::error('Bu işlemi yapmak için yetkiniz yok.');
                return;
            }
        } else {
            $response = Gate::inspect('create', [Like::class, $this->post]);
            if (!$response->allowed()) {
                Toaster::error('Bu işlemi yapmak için yetkiniz yok.');
                return;
            }
        }

        $this->post->toggleLike();
    }

    public function render()
    {
        return view('livewire.post.pages.show-post')
            ->title($this->post->title . ' - ' . config('app.name'));
    }
}
