<?php

namespace App\Livewire\ZalimKasaba;

use App\Models\ZalimKasaba\Lobby;
use App\Models\ZalimKasaba\Player;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ShowLastWill extends Component
{
    public Lobby $lobby;
    public ?Player $author;
    public ?string $lastWill;
    public ?string $title;

    public function mount(Lobby $lobby, Player | null $author = null, string | null $lastWill = null)
    {
        $this->lobby = $lobby;
        $this->author = $author;
        $this->lastWill = $lastWill;
        $this->title = 'Vasiyet';
    }

    public function getListeners()
    {
        return [
            "show-last-will" => 'loadLastWill',
        ];
    }

    public function loadLastWill(int $playerId)
    {
        $this->author = $this->lobby->players()->find($playerId);

        if (!$this->author) {
            $this->title = 'Oyuncu Bulunamadı';
            Toaster::error('Oyuncu bulunamadı.');
            return;
        }

        $this->title = $this->author->user->username . ' Vasiyeti';

        if ($this->author->last_will === null) {
            $this->lastWill = 'Bu kişi vasiyet bırakmamış.';
            return;
        }

        $this->lastWill = $this->author->last_will;
    }

    public function unLoadLastWill()
    {
        $this->author = null;
        $this->lastWill = null;
    }

    public function render()
    {
        return view('livewire.zalim-kasaba.show-last-will');
    }
}
