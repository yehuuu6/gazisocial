<?php

namespace App\Livewire\ZalimKasaba;

use App\Enums\ZalimKasaba\ChatMessageFaction;
use App\Enums\ZalimKasaba\GameState;
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
        if ($this->currentPlayer->role) {
            $isMafia = $this->currentPlayer->isMafia();
        } else {
            $isMafia = false;
        }

        return $this->lobby->messages()
            ->where('day_count', $dayCount)
            ->where(function ($query) use ($isMafia) {
                // Everyone can see messages with faction ALL
                $query->where(function ($q) {
                    $q->where('faction', ChatMessageFaction::ALL)
                        ->whereNull('receiver_id');
                });

                // Only Mafia members can see MAFIA messages
                if ($isMafia) {
                    $query->orWhere(function ($q) {
                        $q->where('faction', ChatMessageFaction::MAFIA)
                            ->whereNull('receiver_id');
                    });
                }

                // Only dead players can see DEAD messages
                if (!$this->currentPlayer->is_alive) {
                    $query->orWhere(function ($q) {
                        $q->where('faction', ChatMessageFaction::DEAD)
                            ->whereNull('receiver_id');
                    });
                }

                // Direct messages to the player are always visible regardless of faction
                $query->orWhere('receiver_id', Auth::id());
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
