<?php

namespace App\Livewire\ZalimKasaba;

use App\Enums\ZalimKasaba\ChatMessageFaction;
use Livewire\Component;
use App\Models\ZalimKasaba\Lobby;
use App\Models\ZalimKasaba\Player;
use Illuminate\Support\Facades\Auth;
use App\Traits\ZalimKasaba\ChatManager;

class ChatWindow extends Component
{
    use ChatManager;

    public Lobby $lobby;

    public string $message = '';

    public $messages;

    public Player $currentPlayer;

    public $oldMessages;
    public $selectedDayCount;

    public bool $chatHistoryModal = false;

    public function mount(Lobby $lobby)
    {
        $this->lobby = $lobby;
        $this->currentPlayer = $this->lobby->players()->where('user_id', Auth::id())->first();
        $this->messages = $this->fetchMessages($this->lobby->day_count);
        $this->selectedDayCount = $this->lobby->day_count;
        $this->oldMessages = $this->messages;
    }

    public function getListeners()
    {
        return [
            "echo-presence:zalim-kasaba-lobby.{$this->lobby->id},.game.new.message" => 'handleNewChatMessage',
        ];
    }

    public function loadChatHistory(int $dayCount)
    {
        $this->selectedDayCount = $dayCount;
        $this->oldMessages = $this->fetchMessages($dayCount);
    }

    private function fetchMessages(int $dayCount)
    {
        return $this->lobby->messages()
            ->where('day_count', $dayCount)
            ->where(function ($query) {
                $query->whereNull('receiver_id')
                    ->orWhere('receiver_id', Auth::id());
            })
            ->where(function ($query) {
                if ($this->currentPlayer->is_alive) {
                    $query->where(function ($q) {
                        $q->where('faction', '!=', ChatMessageFaction::DEAD->value)
                            ->orWhere('receiver_id', Auth::id());
                    });
                }
            })
            ->oldest()
            ->get();
    }

    public function handleNewChatMessage($payload)
    {
        $this->messages = $this->fetchMessages($this->lobby->day_count);
        $this->dispatch('chat-message-received');
    }

    public function render()
    {
        return view('livewire.zalim-kasaba.chat-window');
    }
}
