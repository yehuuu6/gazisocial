<?php

namespace App\Livewire\ZalimKasaba;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use App\Models\ZalimKasaba\Lobby;
use App\Models\ZalimKasaba\Player;
use App\Traits\ZalimKasaba\ChatManager;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Enums\ZalimKasaba\ChatMessageFaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LastWillModal extends Component
{
    use ChatManager;

    public Lobby $lobby;
    public Player $currentPlayer;

    public ?string $lastWill = '';

    public function mount(Lobby $lobby)
    {
        $this->lobby = $lobby;
        $this->currentPlayer = $this->lobby->players()->where('user_id', Auth::id())->first();
        $this->lastWill = $this->currentPlayer->last_will;
    }

    public function sendLastWillToChat()
    {
        if ($this->lastWill == '' || !$this->canSendMessages()) return;

        $faction = match ($this->currentPlayer->is_alive) {
            1 => ChatMessageFaction::ALL,
            0 => ChatMessageFaction::DEAD,
        };

        $this->sendMessageAsPlayer($this->currentPlayer, $this->lastWill, faction: $faction);
    }

    public function saveLastWill()
    {
        if ($this->lastWill === '') {
            return;
        }

        if ($this->currentPlayer->last_will === $this->lastWill) {
            return;
        }

        if (!$this->currentPlayer->is_alive) {
            Toaster::error('Ölüyken vasiyetinizi değiştiremezsiniz!');
            $this->lastWill = $this->currentPlayer->last_will;
            return;
        };

        $messages = [
            'lastWill.max' => 'Vasiyetiniz en fazla 1000 karakter olabilir.'
        ];

        try {
            $this->validate([
                'lastWill' => 'max:1000'
            ], $messages);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->first();
            Toaster::error($errors);
            return;
        }

        $this->currentPlayer->update([
            'last_will' => $this->lastWill
        ]);

        Toaster::success('Vasiyetiniz başarıyla kaydedildi.');
    }

    public function render()
    {
        return view('livewire.zalim-kasaba.last-will-modal');
    }
}
