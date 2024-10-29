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

    public function render()
    {

        if ($this->isPrivateProfile() && Gate::denies('view', $this->user)) {
            return view('livewire.components.user-private-profile');
        }

        switch ($this->currentView) {
            case 'user-comments':
                return view('livewire.pages.users.user-comments-page', [
                    'comments' => $this->user->comments()
                        ->with('user')
                        ->latest('created_at')
                        ->simplePaginate(20),
                ]);
            default:
                return view('livewire.pages.users.user-posts-page', [
                    'posts' => $this->user->posts()
                        ->with('user')
                        ->with('tags')
                        ->latest('created_at')
                        ->simplePaginate(20),
                ]);
        }
    }
}
