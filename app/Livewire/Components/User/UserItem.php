<?php

namespace App\Livewire\Components\User;

use Livewire\Component;
use Illuminate\Support\Str;

class UserItem extends Component
{

    public $user;
    public $bio;

    public $colorVariants = [
        'blue' => 'bg-blue-700',
        'red' => 'bg-red-700',
        'green' => 'bg-green-700',
    ];

    public function mount($user)
    {
        $this->user = $user;
        $this->bio = Str::limit($this->user->bio, 150, '...') ?? 'Herhangi bir bilgi verilmemiş.';
    }

    public function render()
    {
        return view('livewire.components.user.user-item');
    }
}
