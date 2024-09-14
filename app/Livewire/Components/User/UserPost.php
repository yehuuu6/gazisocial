<?php

namespace App\Livewire\Components\User;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserPost extends Component
{

    use LivewireAlert;

    public Post $post;

    public function deletePost()
    {
        $response = Gate::inspect('delete', $this->post);

        if ($response->allowed()) {
            $this->post->delete();
            $this->alert('success', 'Gönderi başarıyla silindi.');
            $this->dispatch('userPostDeleted');
            $this->dispatch('showUserPosts');
        } else {
            $this->alert('error', 'Bu işlemi yapmaya yetkiniz yok.');
        }
    }

    public function render()
    {
        return view('livewire.components.user.user-post');
    }
}
