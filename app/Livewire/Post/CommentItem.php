<?php

namespace App\Livewire\Post;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;

class CommentItem extends Component
{

    use LivewireAlert, WithRateLimiting;

    public Comment $comment;
    public Post $post;

    public $content;

    public int $initialMaxReplyCount = 5;
    public int $maxReplyCount;

    public function mount()
    {
        if ($this->comment->depth <= 5) {
            // If the depth is less than or equal to 5, we will show 5 replies.
            $this->maxReplyCount = $this->initialMaxReplyCount;
        } else {
            // If the depth is greater than 5, we will show 1 less reply on each level.
            // So, if the depth is 6, we will show 4, if the depth is 7, we will show 3, and so on.
            $this->maxReplyCount = (($this->comment->depth - 5) - $this->initialMaxReplyCount) * -1;
        }
    }

    public function placeholder()
    {
        return view('components.post.comment-placeholder');
    }

    public function addReply()
    {
        $response = Gate::inspect('create', Comment::class);

        if (!$response->allowed()) {
            $this->alert('error', 'Yorum yapmak e-posta onaylı bir hesap gerektirir.');
            $this->dispatch('auth-required');
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

        $this->comment->replies()->create([
            ...$validated,
            'post_id' => $this->post->id,
            'user_id' => Auth::id(),
            'commentable_id' => $this->comment->id,
            'commentable_type' => $this->comment->getMorphClass(),
            'depth' => $this->comment->depth + 1
        ]);

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

        $comment->delete();

        $this->alert('success', 'Yorum başarıyla silindi.');

        $this->dispatch('comment-deleted');
    }

    public function render()
    {
        $this->comment->loadCount('replies');

        return view('livewire.post.comment-item');
    }
}
