<?php

namespace App\Livewire\Pages\Faculty;

use Livewire\Component;
use App\Models\Faculty;

class ListFaculties extends Component
{

    public $faculties;
    public $vocationals;

    public function mount()
    {
        $this->faculties = Faculty::where('type', 'faculty')->get();
        $this->vocationals = Faculty::where('type', 'vocational')->get();
    }

    public function render()
    {
        return view('livewire.pages.faculty.list-faculties');
    }
}
