<?php

namespace App\Livewire\Post\Pages;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Home extends Component
{

    use LivewireAlert;

    public function render()
    {
        if (session()->has('emailVerified')) {
            $this->alert('success', session('emailVerified'));
        }
        return view('livewire.post.pages.home');
    }
}
