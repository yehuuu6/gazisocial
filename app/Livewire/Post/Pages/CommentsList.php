<?php

namespace App\Livewire\Post\Pages;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;
use App\Models\Notification;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Events\NotificationReceived;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Masmerise\Toaster\Toaster;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class CommentsList extends Component
{
    use WithPagination, WithRateLimiting;

    public Post $post;

    public bool $showRegisterModal = false;
    public bool $commentForm = false; // Comment form visibility

    public string $sortBy = 'popularity';

    public $content;

    protected $listeners = [
        'auth-required' => 'showModal',
    ];

    public function showModal()
    {
        $this->showRegisterModal = true;
    }

    public function redirectAuth(string $route)
    {
        // Redirect to the login page with the intended route
        return redirect()->setIntendedUrl($this->post->showRoute())->route($route);
    }

    public function getSortMethodProperty()
    {
        // Return created_at if the sortBy property is 'newest' or 'oldest' and return 'popularity' otherwise
        return $this->sortBy === 'newest' || $this->sortBy === 'oldest' ? 'created_at' : 'popularity';
    }

    public function createNotification(string $url): void
    {

        if ($this->post->user_id === Auth::id()) {
            return;
        }

        Notification::create(
            [
                'user_id' => $this->post->user_id,
                'type' => 'post_comment',
                'data' => [
                    'sender_id' => Auth::id(),
                    'post_id' => $this->post->id,
                    'action_url' => $url,
                    'text' => Auth::user()->name . ' gönderinize yorum yaptı'
                ],
            ]
        );

        broadcast(new NotificationReceived(receiver: $this->post->user))->toOthers();
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

    private function handleCommentCreation(?string $content = null, ?string $gifUrl = null)
    {
        if (!Auth::check()) {
            $this->dispatch('auth-required');
            return false;
        }

        $response = Gate::inspect('create', Comment::class);

        if (!$response->allowed()) {
            Toaster::warning('Yorum yapmak için yetkiniz yok.');
            return false;
        }

        if ($content) {
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
                $commentData = [...$validated];
            } catch (ValidationException $e) {
                Toaster::error($e->validator->errors()->first());
                return false;
            }
        } else {
            $commentData = [];
        }

        if ($gifUrl) {
            $commentData['gif_url'] = $gifUrl;
        }

        $commentData = [
            ...$commentData,
            'post_id' => $this->post->id,
            'parent_id' => null,
            'user_id' => Auth::id(),
            'commentable_id' => $this->post->id,
            'commentable_type' => $this->post->getMorphClass()
        ];

        $comment = $this->post->comments()->create($commentData);

        $this->createNotification($comment->showRoute());
        $this->resetPage();
        Toaster::success('Yorumunuz başarıyla eklendi.');
        $this->reset('content');
        $this->dispatch('comment-added');
        $this->commentForm = false;

        return true;
    }

    public function sendGif(string $gifUrl)
    {
        return $this->handleCommentCreation(gifUrl: $gifUrl);
    }

    public function addComment()
    {
        return $this->handleCommentCreation($this->content);
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

        Toaster::success('Yorum başarıyla silindi.');

        $this->dispatch('comment-deleted', decreaseCount: $countToDecrease);
    }

    public function render()
    {
        return view('livewire.post.pages.comments-list');
    }
}
