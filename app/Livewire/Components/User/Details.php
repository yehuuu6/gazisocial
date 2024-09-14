<?php

namespace App\Livewire\Components\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class Details extends Component
{
    public User $user;

    public function loadCounts()
    {
        $this->user->loadCount('comments');
        $this->user->loadCount('posts');
    }

    public function mount()
    {
        $this->loadCounts();
    }

    #[On('userCommentDeleted')]
    #[On('userPostDeleted')]
    public function refreshPage()
    {
        $this->user->refresh();
        $this->loadCounts();
    }

    public function render()
    {
        return view('livewire.components.user.details');
    }
}
