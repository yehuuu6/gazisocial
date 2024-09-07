<?php

namespace App\Livewire\Components\Post;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Comment extends Component
{

    use LivewireAlert;

    public $comment;

    public $postAuthor;

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
    }

    public function render()
    {
        return view('livewire.components.post.comment');
    }
}
