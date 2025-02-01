<?php

namespace App\Livewire\User\Pages;

use App\Models\User;
use Livewire\Component;

class ShowUser extends Component
{
    public User $user;

    public array $colorVariants = [
        'blue' => 'bg-blue-700',
        'red' => 'bg-red-700',
        'green' => 'bg-green-700',
        'yellow' => 'bg-yellow-500',
        'orange' => 'bg-orange-500',
        'purple' => 'bg-purple-500',
    ];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.pages.show-user');
    }
}
