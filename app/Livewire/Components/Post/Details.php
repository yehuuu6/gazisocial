<?php

namespace App\Livewire\Components\Post;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Details extends Component
{

    use LivewireAlert;

    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post->loadCount('comments');
    }

    public function placeholder()
    {
        return view('components.posts.big-placeholder');
    }

    public function deletePost()
    {

        $response = Gate::inspect('delete', $this->post);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu konuyu silme izniniz yok.');
            return;
        }

        $this->post->delete();

        session()->flash('post-deleted', 'Konu başarıyla silindi.');

        $this->redirect(route('user.show', $this->post->user), navigate: true);
    }

    #[On('comment-created')]
    #[On('comment-deleted')]
    public function refreshPage()
    {
        $this->post->refresh();
        $this->post = $this->post->loadCount('comments'); // Load again.
    }

    public function render()
    {
        return view('livewire.components.post.details');
    }
}
