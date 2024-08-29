<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class CommentModal extends ModalComponent
{
    public Post $post;

    #[Validate('required|min:1|max:500|string')]
    public string $content;

    public function createComment()
    {

        if (!Auth::check()) {
            return redirect(route('login'));
        }

        $validated = $this->validate();

        $comment = Comment::make($validated);
        $comment->user()->associate(Auth::user());
        $comment->post()->associate($this->post);
        $comment->save();

        $this->content = '';

        session()->flash('message', 'Yorumunuz başarıyla eklendi.'); // Doesn't work WHY?

        $this->closeModal();
        $this->dispatch('comment-created');
    }

    public function render()
    {
        return view('livewire.modals.comment-modal');
    }
}
