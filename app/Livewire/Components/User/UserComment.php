<?php

namespace App\Livewire\Components\User;

use Livewire\Component;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserComment extends Component
{

    use LivewireAlert;

    public Comment $comment;

    public function deleteComment()
    {
        $response = Gate::inspect('delete', $this->comment);

        if ($response->allowed()) {
            $this->comment->delete();
            $this->alert('success', 'Yorum başarıyla silindi.');
            $this->dispatch('userCommentDeleted');
            $this->dispatch('showUserComments');
        } else {
            $this->alert('error', 'Bu işlemi yapmaya yetkiniz yok.');
        }
    }

    public function render()
    {
        $this->comment->load('user', 'post');

        // Shorten the comment content if it has more characters than 500, and add ...
        if (strlen($this->comment->content) > 500) {
            $this->comment->content = substr($this->comment->content, 0, 500) . '...';
        }

        return view('livewire.components.user.user-comment');
    }
}
