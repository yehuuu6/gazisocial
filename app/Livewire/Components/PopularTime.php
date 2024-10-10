<?php

namespace App\Livewire\Components;

use Livewire\Component;

class PopularTime extends Component
{
    public $text = 'Zaman aralığı içinde';
    public $time;
    public $validTimes = ['today', 'this_week', 'three_months', 'six_months', 'this_year', 'all_time'];

    public function mount()
    {
        // Retrieve the saved time period state from the session
        $saved = session('time_period') ?? 'today';
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
                $this->text = 'Bugün';
                $this->time = 'today';
                break;
        }
    }

    public function setTimePeriod(string $period)
    {
        if (!in_array($period, $this->validTimes)) {
            $period = 'today';
        }

        // Set session time period
        session(['time_period' => $period]);

        $this->updateTexts($period);

        $this->dispatch('time-period-updated');
    }

    public function render()
    {
        return view('livewire.components.popular-time');
    }
}
