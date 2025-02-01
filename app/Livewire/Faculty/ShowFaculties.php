<?php

namespace App\Livewire\Faculty;

use Livewire\Component;
use App\Models\Faculty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Masmerise\Toaster\Toaster;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class ShowFaculties extends Component
{
    use WithRateLimiting;

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
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        $user = Auth::user();

        if (!$user->faculty) {
            Toaster::error('Bir fakülteden ayrılmak için öncelikle bir fakülteye katılmalısınız.');
            return;
        }

        /**
         * @var \App\Models\User $user
         */
        $user->faculty()->dissociate();
        $user->save();
        Toaster::info('Fakülteden ayrıldınız.');
    }

    public function joinFaculty($facultyId)
    {

        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        $response = Gate::inspect('join', Faculty::class);
        if (!$response->allowed()) {
            Toaster::error('Bir fakülteye katılmak için gerekli izinlere sahip değilsiniz.');
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
            $msg = 'ne katıldınız.';
        } else {
            $msg = 'na katıldınız.';
        }

        return redirect(route('users.edit', $user->username))
            ->info($faculty->name . $msg);
    }

    public function render()
    {
        return view('livewire.faculty.show-faculties');
    }
}
