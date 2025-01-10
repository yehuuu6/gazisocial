<?php

namespace App\Livewire\Post\Pages;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class CommentsList extends Component
{

    use WithPagination, LivewireAlert, WithRateLimiting;

    public Post $post;

    public string $sortBy = 'popularity';

    public $content;

    protected $listeners = [
        'gif-selected' => 'addComment',
    ];

    public function getSortMethodProperty()
    {
        // Return created_at if the sortBy property is 'newest' or 'oldest' and return 'popularity' otherwise
        return $this->sortBy === 'newest' || $this->sortBy === 'oldest' ? 'created_at' : 'popularity';
    }

    public function setSortMethod($method)
    {

        if (!in_array($method, ['popularity', 'newest', 'oldest'])) {
            return;
        }

        // If the sort method is the same as the current one, return
        if ($this->sortBy === $method) {
            return;
        }

        $this->sortBy = $method;

        unset($this->comments);

        $this->resetPage();
    }

    public function placeholder()
    {
        return view('components.post.comment-list-placeholder');
    }

    public function addComment(string $gifUrl = null)
    {

        if (!Auth::check()) {
            $this->dispatch('auth-required', msg: 'Yorum yapabilmek için');
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

        if (!$gifUrl) {
            try {
                $validated = $this->validate([
                    'content' => 'required|string|min:3|max:1000',
                ], $messages);
            } catch (ValidationException $e) {
                $this->alert('error', $e->getMessage());
                return;
            }
        } else {
            $validated = [];
        }

        $this->post->comments()->create([
            ...$validated,
            'post_id' => $this->post->id,
            'parent_id' => null,
            'user_id' => Auth::id(),
            'gif_url' => $gifUrl,
            'commentable_id' => $this->post->id,
            'commentable_type' => $this->post->getMorphClass()
        ]);

        $this->resetPage();

        $this->alert('success', 'Yorumunuz başarıyla eklendi.');

        $this->reset('content');
        $this->dispatch('comment-added');
    }

    public function updatingPage()
    {
        $this->dispatch('updating-comments-page');
    }

    #[Computed]
    public function comments()
    {
        $newComment = null;

        if (Auth::check()) {
            $newComment = $this->post->comments()
                ->where('user_id', Auth::id())
                ->where('created_at', '>', now()->subSeconds(10))
                ->latest()
                ->first();
        }

        $sortType = $this->sortBy === 'newest' || $this->sortBy === 'popularity' ? 'desc' : 'asc';

        $comments = $this->post->comments()
            ->with('user')
            ->withCount('replies')
            ->orderBy($this->getSortMethodProperty(), $sortType)
            ->simplePaginate(10);

        // If there is a new comment, inject it into the paginated result
        if ($newComment) {
            $commentsCollection = $comments->getCollection();

            // Remove the normal instance of the new comment if it exists
            $commentsCollection = $commentsCollection->filter(function ($comment) use ($newComment) {
                return $comment->id !== $newComment->id;
            });

            // Add the new comment at the beginning
            $commentsCollection->prepend($newComment);

            // Update the collection in the paginator
            $comments->setCollection($commentsCollection);
        }

        return $comments;
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
        return view('livewire.post.pages.comments-list');
    }
}
