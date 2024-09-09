<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Activity;

class UserActivities extends Component
{

    public function placeholder()
    {
        return view('components.activity-placeholder');
    }

    public function render()
    {
        return view('livewire.components.user-activities', [
            'activities' => Activity::with('user')->latest('created_at')->limit(20)->get()
        ]);
    }
}
