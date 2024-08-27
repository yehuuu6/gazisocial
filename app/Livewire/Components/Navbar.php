<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{

    public function destroy(){
        Auth::logout();
        return $this->redirect('/login', navigate: true);
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }
}
