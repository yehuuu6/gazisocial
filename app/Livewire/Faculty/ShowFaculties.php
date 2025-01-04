<?php

namespace App\Livewire\Faculty;

use Livewire\Component;
use App\Models\Faculty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class ShowFaculties extends Component
{

    use LivewireAlert, WithRateLimiting;

    public $faculties;
    public $vocationals;

    public function mount()
    {
        $this->faculties = Faculty::where('type', 'faculty')->get();
        $this->vocationals = Faculty::where('type', 'vocational')->get();
    }

    public function leaveFaculty()
    {

        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

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

        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

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

        $this->alert('info', 'Yönlendiriliyorsunuz...');

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
        return view('livewire.faculty.show-faculties');
    }
}
