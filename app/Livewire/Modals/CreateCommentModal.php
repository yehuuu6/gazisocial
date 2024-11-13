<?php

namespace App\Livewire\Modals;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class CreateCommentModal extends Component
{

    use LivewireAlert, WithRateLimiting;

    public Post $post;

    public string $content = '';

    public function createComment()
    {
        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        $response = Gate::inspect('create', Comment::class);

        if (!$response->allowed()) {
            $this->alert('error', 'Yorum yapmak e-posta onaylı bir hesap gerektirir.');
            return;
        }

        $messages = [
            'required' => 'Yorum içeriği boş olamaz.',
            'min' => 'Yorum içeriği en az :min karakter olmalıdır.',
            'max' => 'Yorum içeriği en fazla :max karakter olabilir.',
            'string' => 'Yorum içeriği metin olmalıdır.',
        ];

        try {
            $validated = $this->validate([
                'content' => 'required|string|min:3|max:255',
            ], $messages);
        } catch (ValidationException $e) {
            $this->alert('error', $e->getMessage());
            return;
        }

        Comment::create([
            ...$validated,
            'user_id' => Auth::id(),
            'post_id' => $this->post->id,
        ]);

        $this->content = '';

        $this->alert('success', 'Yorum eklendi.');

        $this->dispatch('comment-created');
    }

    public function render()
    {
        return view('livewire.modals.create-comment-modal');
    }
}
