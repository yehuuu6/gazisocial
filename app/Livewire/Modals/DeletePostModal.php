<?php

namespace App\Livewire\Modals;

use App\Models\Post;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Gate;

class DeletePostModal extends ModalComponent
{

    use LivewireAlert;

    public $postId;
    public Post $post;

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->post = Post::make()->findOrFail($this->postId);
    }

    public function deletePost()
    {

        $response = Gate::inspect('delete', $this->post);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu konuyu silme izniniz yok.');
            return;
        }

        $this->post->delete();

        $this->closeModal();

        $this->flash('success', 'Konu silindi.');
    }

    public function render()
    {
        return view('livewire.modals.delete-post-modal');
    }
}
