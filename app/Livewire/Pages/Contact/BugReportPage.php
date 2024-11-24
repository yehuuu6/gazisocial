<?php

namespace App\Livewire\Pages\Contact;

use App\Models\ReportedBug as Bug;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

#[Title('Hata bildir - Gazi Social')]
class BugReportPage extends Component
{

    use LivewireAlert, WithRateLimiting;

    public string $title = '';
    public string $description = '';

    public function reportBug()
    {

        try {
            $this->rateLimit(5, decaySeconds: 180);
        } catch (TooManyRequestsException $exception) {
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        $messages = [
            'title.required' => 'Başlık alanı boş bırakılamaz.',
            'title.min' => 'Başlık en az :min karakter olmalıdır.',
            'title.max' => 'Başlık en fazla :max karakter olmalıdır.',
            'description.required' => 'Açıklama alanı boş bırakılamaz.',
            'description.min' => 'Açıklama en az :min karakter olmalıdır.',
            'description.max' => 'Açıklama en fazla :max karakter olmalıdır.',
        ];

        try {
            $this->validate([
                'title' => 'required|min:5|max:50',
                'description' => 'required|min:10|max:1000',
            ], $messages);
        } catch (ValidationException $e) {
            $this->alert('error', $e->getMessage());
            return;
        }

        $validated = [
            'title' => $this->title,
            'description' => $this->description,
        ];

        Bug::create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        $this->alert('success', 'Hata başarıyla bildirildi. Teşekkür ederiz.');

        $this->title = '';
        $this->description = '';
    }

    public function render()
    {
        return view('livewire.pages.contact.bug-report-page');
    }
}
