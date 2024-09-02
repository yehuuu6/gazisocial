<?php

namespace App\Livewire\Modals;

use App\Models\Comment;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Gate;

class DeleteCommentModal extends ModalComponent
{

    use LivewireAlert;

    public $commentId;
    public Comment $comment;

    public function mount($commentId)
    {
        $this->commentId = $commentId;
        $this->comment = Comment::make()->findOrFail($this->commentId);
    }

    public function deleteComment()
    {

        $response = Gate::inspect('delete', $this->comment);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu yorumu silme izniniz yok.');
            return;
        }

        $this->comment->delete();

        $this->alert('success', 'Yorum silindi.');

        $this->dispatch('comment-deleted');

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.modals.delete-comment-modal');
    }
}
