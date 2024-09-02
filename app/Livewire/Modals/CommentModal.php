<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class CommentModal extends ModalComponent
{

    use LivewireAlert;

    public Post $post;

    #[Validate('required', message: 'Yorum içeriği boş olamaz.')]
    #[Validate('min:3', message: 'Yorum içeriği en az 3 karakter olmalıdır.')]
    #[Validate('max:1000', message: 'Yorum içeriği en fazla 1000 karakter olabilir.')]
    #[Validate('string', message: 'Yorum içeriği metin olmalıdır.')]
    public string $content;

    public function createComment()
    {

        $response = Gate::inspect('create', Comment::class);

        if (!$response->allowed()) {
            $this->alert('error', 'Yorum yapmak e-posta onaylı bir hesap gerektirir.');
            return;
        }

        $validated = $this->validate();

        $comment = Comment::make($validated);
        $comment->user()->associate(Auth::user());
        $comment->post()->associate($this->post);
        $comment->save();

        $this->content = '';

        $this->alert('success', 'Yorum eklendi.');

        $this->closeModal();
        $this->dispatch('comment-created');
    }

    public function render()
    {
        return view('livewire.modals.comment-modal');
    }
}
