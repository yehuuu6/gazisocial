<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Activity;

class MobileUserActivities extends Component
{
    public function render()
    {
        return view('livewire.components.mobile-user-activities', [
            'activities' => Activity::with('user')->latest('created_at')->limit(20)->get()
        ]);
    }
}
