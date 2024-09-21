<?php

namespace App\Livewire\Modals;

use App\Models\Comment;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class DeleteCommentModal extends Component
{

    use LivewireAlert;

    public $commentId = null;

    public function deleteComment()
    {

        $comment = Comment::find($this->commentId);

        $response = Gate::inspect('delete', $comment);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu yorumu silme izniniz yok.');
            return;
        }

        $comment->delete();

        $comment->post->decrement('comments_count');

        $this->alert('success', 'Yorum silindi.');

        $this->dispatch('comment-deleted');
        $this->dispatch('userCommentDeleted');
        $this->dispatch('showUserComments');
    }

    public function render()
    {
        return view('livewire.modals.delete-comment-modal');
    }
}
