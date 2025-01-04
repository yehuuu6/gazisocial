<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class PopularTime extends Component
{
    public $text = 'Zaman aralığı içinde';
    public $time;
    public $validTimes = ['today', 'one_week', 'three_months', 'six_months', 'one_year', 'all_time'];

    public function mount()
    {
        // Retrieve the saved time period state from the session
        $saved = session('time_period') ?? 'all_time';
        $this->time = $saved;
        $this->updateTexts($saved);
    }

    public function updateTexts(string $time)
    {
        switch ($time) {
            case 'today':
                $this->text = 'Bugün';
                $this->time = 'today';
                break;
            case 'one_week':
                $this->text = 'Bir Hafta';
                $this->time = 'one_week';
                break;
            case 'three_months':
                $this->text = 'Üç Ay';
                $this->time = 'three_months';
                break;
            case 'six_months':
                $this->text = 'Altı Ay';
                $this->time = 'six_months';
                break;
            case 'one_year':
                $this->text = 'Bir Yıl';
                $this->time = 'one_year';
                break;
            case 'all_time':
                $this->text = 'Tüm Zamanlar';
                $this->time = 'all_time';
                break;
            default:
                $this->text = 'Tüm Zamanlar';
                $this->time = 'all_time';
                break;
        }
    }

    public function setTimePeriod(string $period)
    {
        if (!in_array($period, $this->validTimes)) {
            $period = 'all_time';
        }

        // Set session time period
        session(['time_period' => $period]);

        $this->updateTexts($period);

        $this->dispatch('time-period-updated');
    }

    public function render()
    {
        return view('livewire.layout.popular-time');
    }
}
