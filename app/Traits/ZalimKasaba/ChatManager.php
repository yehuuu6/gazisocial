<?php

namespace App\Traits\ZalimKasaba;

use App\Enums\ZalimKasaba\ChatMessageFaction;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Enums\ZalimKasaba\GameState;
use App\Enums\ZalimKasaba\PlayerRole;
use App\Models\ZalimKasaba\Lobby;
use App\Models\ZalimKasaba\Player;
use App\Models\ZalimKasaba\ChatMessage;
use App\Events\ZalimKasaba\NewChatMessage;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Auth;

trait ChatManager
{
    /**
     * Sends a message to the every player in the lobby
     * @param string $msg
     * @param ChatMessageType $type
     * @param ChatMessageFaction $faction
     * @return void
     */
    private function sendSystemMessage(
        string $msg,
        ChatMessageType $type = ChatMessageType::DEFAULT,
        ChatMessageFaction $faction = ChatMessageFaction::ALL
    ) {
        $message = $this->lobby->messages()->create([
            'message' => $msg,
            'type' => $type,
            'faction' => $faction,
        ]);

        broadcast(new NewChatMessage($this->lobby->id, $message->id));
    }

    /**
     * Sends a message to the given player
     * @param Player $player that will receive the message
     * @param string $msg the message
     * @param ChatMessageType $type the type of the message
     * @return void
     */
    private function sendMessageToPlayer(Player $player, string $msg, ChatMessageType $type = ChatMessageType::DEFAULT)
    {
        // Only send a message to the given player.
        $message = $this->lobby->messages()->create([
            'message' => $msg,
            'receiver_id' => $player->user->id,
            'type' => $type,
            'faction' => ChatMessageFaction::ALL,
        ]);

        broadcast(new NewChatMessage($this->lobby->id, $message->id));
    }

    private function canSendMessages(): bool
    {
        $statesAllowedToChat = [
            GameState::LOBBY,
            GameState::DAY,
            GameState::VOTING,
            GameState::JUDGMENT,
            GameState::PREPARATION,
        ];

        $gameState = $this->lobby->state;
        $myPlayer = $this->currentPlayer;

        if ($gameState === GameState::DEFENSE && $myPlayer->id === $this->lobby->accused_id) {
            return true;
        } elseif ($gameState === GameState::LAST_WORDS && $myPlayer->id === $this->lobby->accused_id) {
            return true;
        } elseif ($gameState === GameState::NIGHT && $myPlayer->isMafia()) {
            return true;
        }

        return in_array($this->lobby->state, $statesAllowedToChat);
    }

    private function getMessageFaction(): ChatMessageFaction
    {
        $myPlayer = $this->currentPlayer;

        if (!$myPlayer->is_alive) {
            return ChatMessageFaction::DEAD;
        }

        if ($this->lobby->state === GameState::NIGHT && in_array($myPlayer->role->enum, PlayerRole::getMafiaRoles())) {
            return ChatMessageFaction::MAFIA;
        }

        return ChatMessageFaction::ALL;
    }

    public function isDeadChat(ChatMessage $msg): bool
    {
        return $msg->faction === ChatMessageFaction::DEAD && !$this->currentPlayer->is_alive;
    }

    public function isMafiaChat(ChatMessage $msg): bool
    {
        $allowedStates = [
            GameState::NIGHT,
            GameState::REVEAL,
        ];
        return $msg->faction === ChatMessageFaction::MAFIA && $this->currentPlayer->isMafia() && in_array($this->lobby->state, $allowedStates);
    }

    public function sendMessage()
    {
        // Trim message
        $this->message = trim($this->message);

        if (empty($this->message) || !$this->canSendMessages()) {
            return;
        }

        $message = $this->lobby->messages()->create([
            'user_id' => Auth::id(),
            'message' => $this->message,
            'faction' => $this->getMessageFaction(),
            'type' => ChatMessageType::DEFAULT,
        ]);

        $this->messages->push($message);

        // Broadcast message
        broadcast(new NewChatMessage($this->lobby->id, $message->id))->toOthers();

        $this->message = '';
    }
}
