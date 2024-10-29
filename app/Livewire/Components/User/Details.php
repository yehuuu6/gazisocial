<?php

namespace App\Livewire\Components\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class Details extends Component
{
    public User $user;

    public $colorVariants = [
        'blue' => 'bg-blue-700',
        'red' => 'bg-red-700',
        'green' => 'bg-green-700',
        'yellow' => 'bg-yellow-500',
    ];

    public $bio;

    public function mount(User $user)
    {
        $this->user = $user;

        if ($this->user->bio === null || empty($this->user->bio)) {
            $this->bio = 'Herhangi bir bilgi verilmemiş.';
        } else {
            $this->bio = $user->bio;
        }
    }

    #[On('userCommentDeleted')]
    #[On('userPostDeleted')]
    #[On('avatar-updated')]
    public function refreshPage()
    {
        $this->user->refresh();
    }

    public function render()
    {
        return view('livewire.components.user.details');
    }
}
