<?php

namespace App\Livewire\Pages;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class HomePage extends Component
{

    use LivewireAlert;

    public function render()
    {
        if (session()->has('emailVerified')) {
            $this->alert('success', session('emailVerified'));
        }
        return view('livewire.pages.home-page');
    }
}
