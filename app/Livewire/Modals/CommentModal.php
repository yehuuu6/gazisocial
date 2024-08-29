<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class CommentModal extends ModalComponent
{

    use LivewireAlert;

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

        $this->alert('success', 'Comment created.', [
            'customClass' => [
                'title' => 'bg-blue-500', // This class does work but other stlyes won't work.
            ]
        ]);

        $this->closeModal();
        $this->dispatch('comment-created');
    }

    public function render()
    {
        return view('livewire.modals.comment-modal');
    }
}
