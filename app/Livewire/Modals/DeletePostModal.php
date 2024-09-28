<?php

namespace App\Livewire\Modals;

use App\Models\Post;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class DeletePostModal extends Component
{

    use LivewireAlert;

    public $postId = null;

    public function deletePost()
    {

        $post = Post::find($this->postId);

        $response = Gate::inspect('delete', $post);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu konuyu silme izniniz yok.');
            return;
        }

        $post->user->decrement('posts_count');

        $post->delete();

        $this->dispatch('post-deleted');

        session()->flash('post-deleted', 'Konu başarıyla silindi.');

        $this->redirect(route('users.show', $post->user), navigate: true);
    }

    public function render()
    {
        return view('livewire.modals.delete-post-modal');
    }
}
