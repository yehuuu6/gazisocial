<?php

namespace App\Livewire\Pages\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class UserSubPage extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $currentView;
    public User $user;

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
        switch ($this->currentView) {
            case 'user-posts':
                return view('livewire.pages.users.user-posts-page', [
                    'posts' => $this->user
                    ->posts()
                    ->select('id', 'title', 'slug', 'created_at', 'content')
                    ->latest('created_at')
                    ->simplePaginate(10),
                ]);
            case 'user-comments':
                return view('livewire.pages.users.user-comments-page', [
                    'comments' => $this->user
                    ->comments()
                    ->select('id', 'content', 'created_at', 'post_id')
                    ->latest('created_at')
                    ->simplePaginate(10),
                ]);
            case 'user-likes':
                return view('livewire.pages.users.user-likes-page', [
                    'likes' => [],
                ]);
            default:
            return view('livewire.pages.users.user-posts-page', [
                'posts' => $this->user->posts()
                    ->select('id', 'title', 'slug', 'created_at', 'content')
                    ->latest('created_at')
                    ->simplePaginate(10),
                ]);
        }
    }
}
