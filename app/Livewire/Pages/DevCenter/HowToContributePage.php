<?php

namespace App\Livewire\Pages\DevCenter;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Request;

#[Title('Contribution Guide - Gazi Social Dev Center')]
class HowToContributePage extends Component
{

    public $os;

    private function getOSFromUserAgent($userAgent)
    {
        $osArray = [
            'Windows' => 'Windows',
            'Macintosh' => 'Mac',
            'Linux' => 'Linux',
            'iPhone' => 'iOS',
            'iPad' => 'iOS',
            'Android' => 'Android',
        ];

        foreach ($osArray as $key => $value) {
            if (stripos($userAgent, $key) !== false) {
                return $value;
            }
        }

        return 'Unknown OS';
    }

    public function mount()
    {
        $userAgent = Request::header('User-Agent');

        $this->os = $this->getOSFromUserAgent($userAgent);
    }

    public function render()
    {
        return view('livewire.pages.dev-center.how-to-contribute-page');
    }
}
