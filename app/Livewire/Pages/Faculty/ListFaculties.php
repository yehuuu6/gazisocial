<?php

namespace App\Livewire\Pages\Faculty;

use Livewire\Component;
use App\Models\Faculty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ListFaculties extends Component
{

    use LivewireAlert;

    public $faculties;
    public $vocationals;

    public function mount()
    {
        $this->faculties = Faculty::where('type', 'faculty')->get();
        $this->vocationals = Faculty::where('type', 'vocational')->get();
    }

    public function leaveFaculty()
    {
        $user = Auth::user();

        if (!$user->faculty) {
            $this->alert('error', 'Bir fakülteden ayrılmak için öncelikle bir fakülteye katılmalısınız.');
            return;
        }

        /**
         * @var \App\Models\User $user
         */
        $user->faculty()->dissociate();
        $user->save();
        $this->alert('success', 'Fakülteden başarıyla ayrıldınız.');
    }

    public function joinFaculty($facultyId)
    {
        $response = Gate::inspect('join', Faculty::class);
        if (!$response->allowed()) {
            $this->alert('error', 'Bir fakülteye katılmak için gerekli izinlere sahip değilsiniz.');
            return;
        }
        $faculty = $this->faculties->find($facultyId) ?? $this->vocationals->find($facultyId);
        $user = Auth::user();
        /**
         * @var \App\Models\User $user
         */
        $user->faculty()->associate($faculty);
        $user->save();

        if ($faculty->type === 'faculty') {
            $msg = 'ne başarıyla katıldınız.';
        } else {
            $msg = 'na başarıyla katıldınız.';
        }

        $this->flash('success', $faculty->name . $msg, redirect: route('users.edit', $user->username));
    }

    public function render()
    {
        // If there is a session message, show it
        if (session()->has('emailVerifiedStudent')) {
            $this->alert('success', session('emailVerifiedStudent'));
        }
        return view('livewire.pages.faculty.list-faculties');
    }
}
