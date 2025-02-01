<?php

namespace App\Livewire\User\Search;

use Livewire\Component;

class UserItem extends Component
{

    public $user;

    public $colorVariants = [
        'blue' => 'bg-blue-700',
        'red' => 'bg-red-700',
        'green' => 'bg-green-700',
    ];

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.search.user-item');
    }
}
