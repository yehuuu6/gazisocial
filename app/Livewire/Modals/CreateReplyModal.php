<?php

namespace App\Livewire\Modals;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CreateReplyModal extends Component
{

    use LivewireAlert;

    public $content = '';

    public $commentId = null;

    public function addReply()
    {
        $comment = Comment::find($this->commentId);

        $response = Gate::inspect('reply', $comment);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu yoruma yanıt verme izniniz yok.');
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
                'content' => 'required|string|min:3|max:1000',
            ], $messages);
        } catch (ValidationException $e) {
            $this->alert('error', $e->getMessage());
            return;
        }

        $comment->replies()->create([
            ...$validated,
            'user_id' => Auth::id(),
            'comment_id' => $this->commentId,
        ]);

        $this->alert('success', 'Yanıtınız başarıyla eklendi.');

        $this->dispatch('reply-added');

        $this->content = '';
    }

    public function render()
    {
        return view('livewire.modals.create-reply-modal');
    }
}
