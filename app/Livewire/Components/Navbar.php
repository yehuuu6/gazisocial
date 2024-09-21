<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class Navbar extends Component
{

    public function goToSearch($query)
    {
        return $this->redirect(route('post.search', $query), navigate: true);
    }

    #[On('avatar-updated')]
    public function refreshPage()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }
}
