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

    public $content;

    public function placeholder()
    {
        return view('components.post.comment-list-placeholder');
    }

    public function addComment()
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

        try {
            $validated = $this->validate([
                'content' => 'required|string|min:3|max:1000',
            ], $messages);
        } catch (ValidationException $e) {
            $this->alert('error', $e->getMessage());
            return;
        }

        $this->post->comments()->create([
            ...$validated,
            'post_id' => $this->post->id,
            'user_id' => Auth::id(),
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

        $comments = $this->post->comments()
            ->with('user')
            ->withCount('replies')
            ->oldest()
            ->simplePaginate(10);

        // If there is a new comment, inject it into the paginated result
        if ($newComment) {
            $commentsCollection = $comments->getCollection();

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

        $comment->delete();

        $this->alert('success', 'Yorum başarıyla silindi.');

        $this->dispatch('comment-deleted');
    }

    public function render()
    {
        return view('livewire.post.pages.comments-list');
    }
}
