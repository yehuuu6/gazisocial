<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Navbar extends Component
{

    public function goToSearch($query)
    {
        return $this->redirect(route('post.search', $query), navigate: true);
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }
}
