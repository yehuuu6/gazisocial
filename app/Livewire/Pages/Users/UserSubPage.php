<?php

namespace App\Livewire\Pages\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class UserSubPage extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $currentView;
    public User $user;

    public function isPrivateProfile(): bool
    {
        if ($this->user->is_private) return true;

        return false;
    }

    #[On('showUserPosts')]
    public function showUserPosts()
    {
        $this->resetPage();
        $this->currentView = 'user-posts';
    }

    #[On('showUserComments')]
    public function showUserComments()
    {
        $this->resetPage();
        $this->currentView = 'user-comments';
    }

    #[On('showUserLikes')]
    public function showUserLikes()
    {
        $this->resetPage();
        $this->currentView = 'user-likes';
    }

    public function render()
    {

        if ($this->isPrivateProfile() && Gate::denies('view', $this->user)) {
            return view('livewire.components.user-private-profile');
        }

        switch ($this->currentView) {
            case 'user-comments':
                return view('livewire.pages.users.user-comments-page', [
                    'comments' => $this->user->comments()
                        ->select('id', 'user_id', 'content', 'created_at', 'post_id')
                        ->with('user:id')
                        ->latest('created_at')
                        ->simplePaginate(10),
                ]);
            case 'user-likes':
                return view('livewire.pages.users.user-likes-page', [
                    'likes' => $this->user->likes()
                        ->with('user')
                        ->latest('created_at')
                        ->simplePaginate(10),
                ]);
            default:
                return view('livewire.pages.users.user-posts-page', [
                    'posts' => $this->user->posts()
                        ->select('id', 'user_id', 'title', 'created_at', 'content', 'html')
                        ->with('user:id')
                        ->with('tags:id,name,color,slug')
                        ->latest('created_at')
                        ->simplePaginate(10),
                ]);
        }
    }
}
