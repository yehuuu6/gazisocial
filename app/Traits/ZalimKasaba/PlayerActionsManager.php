<?php

namespace App\Traits\ZalimKasaba;

use App\Models\ZalimKasaba\Player;
use App\Enums\ZalimKasaba\GameState;
use App\Enums\ZalimKasaba\ActionType;
use App\Enums\ZalimKasaba\ChatMessageFaction;
use App\Enums\ZalimKasaba\ChatMessageType;
use App\Enums\ZalimKasaba\PlayerRole;
use Illuminate\Support\Facades\Auth;

trait PlayerActionsManager
{
    use ChatManager;

    public function selectTarget(Player $targetPlayer)
    {
        $actionType = $this->getActionType();

        $existingAction = $this->lobby->actions()->where([
            'actor_id' => $this->currentPlayer->id,
            'action_type' => $actionType,
        ])->first();

        if ($existingAction) {
            if ($existingAction->target_id === $targetPlayer->id) {
                $existingAction->delete();
                $this->giveActionFeedback($targetPlayer, false);
                return;
            }

            $existingAction->update([
                'target_id' => $targetPlayer->id,
                'action_type' => $actionType,
            ]);
        } else {
            $this->lobby->actions()->create([
                'actor_id' => $this->currentPlayer->id,
                'target_id' => $targetPlayer->id,
                'action_type' => $actionType,
            ]);
        }

        $this->giveActionFeedback($targetPlayer, true);
    }

    private function giveActionFeedback(Player $targetPlayer, bool $isPositive): void
    {
        if ($this->currentPlayer->isMafia()) {
            $msg = $this->getMafiaBroadcastMessages($targetPlayer, $isPositive);
            $this->sendSystemMessage($msg, ChatMessageType::DEFAULT, ChatMessageFaction::MAFIA);
        } else {
            if ($isPositive) {
                $msg = $this->getActionMessage($targetPlayer);
            } else {
                $msg = $this->getCancelActionMessage($targetPlayer);
            }
            $this->sendMessageToPlayer($this->currentPlayer, $msg);
        }
    }

    private function getMafiaBroadcastMessages(Player $targetPlayer, bool $isPositive): string
    {
        $targetUsername = $targetPlayer->user->username;
        if ($isPositive) {
            return match ($this->currentPlayer->role->enum) {
                PlayerRole::GODFATHER => "Baron {$targetUsername} adlı oyuncunun öldürülmesi için emir verdi.",
                PlayerRole::MAFIOSO => "Tetikçi {$targetUsername} adlı oyuncuyu öldürmeye karar verdi.",
                PlayerRole::JANITOR => "Temizlikçi {$targetUsername} adlı oyuncunun cesedini temizlemeye karar verdi.",
            };
        } else {
            return match ($this->currentPlayer->role->enum) {
                PlayerRole::GODFATHER => "Baron {$targetUsername} adlı oyuncunun öldürülmesi için verdigi emri iptal etti.",
                PlayerRole::MAFIOSO => "Tetikçi {$targetUsername} adlı oyuncuyu öldürmekten vazgeçti.",
                PlayerRole::JANITOR => "Temizlikçi {$targetUsername} adlı oyuncunun cesedini temizlemekten vazgeçti.",
            };
        }
    }

    /**
     * Checks if the current player can use their ability on the target player.
     * @param Player $targetPlayer The player who is targeted by the ability.
     * @return bool True if the player can use ability, false otherwise.
     */
    public function canUseAbility(Player $targetPlayer): bool
    {
        // Basic checks that must be checked for all roles
        if ($this->lobby->state !== GameState::NIGHT) return false;
        if ($this->currentPlayer->user_id !== Auth::id()) return false;

        $myRole = $this->currentPlayer->role->enum;

        if (!$this->currentPlayer->is_alive && $myRole !== PlayerRole::JESTER) return false;

        switch ($myRole) {
            case PlayerRole::GODFATHER:
                if ($this->currentPlayer->id === $targetPlayer->id) return false;
                if (in_array($targetPlayer->role->enum, PlayerRole::getMafiaRoles())) return false;
                break;
            case PlayerRole::MAFIOSO:
                if ($this->currentPlayer->id === $targetPlayer->id) return false;
                if (in_array($targetPlayer->role->enum, PlayerRole::getMafiaRoles())) return false;
                break;
            case PlayerRole::JANITOR:
                if ($this->currentPlayer->id === $targetPlayer->id) return false;
                if (in_array($targetPlayer->role->enum, PlayerRole::getMafiaRoles())) return false;
                if ($this->currentPlayer->ability_uses === 0) return false;
                break;
            case PlayerRole::DOCTOR:
                if ($targetPlayer->id === $this->currentPlayer->id && $this->currentPlayer->self_healed) return false;
                break;
            case PlayerRole::GUARD:
                if ($targetPlayer->id === $this->currentPlayer->id) return false;
                break;
            case PlayerRole::LOOKOUT:
                if ($targetPlayer->id === $this->currentPlayer->id) return false;
                break;
            case PlayerRole::HUNTER:
                if ($targetPlayer->id === $this->currentPlayer->id) return false;
                if ($this->currentPlayer->ability_uses === 0) return false;
                if ($this->currentPlayer->guilt()->exists()) return false;
                break;
            case PlayerRole::WITCH:
                if ($targetPlayer->id === $this->currentPlayer->id) return false;
                if ($this->currentPlayer->ability_uses === 0) return false;
                if ($targetPlayer->poison()->exists()) return false;
                break;
            case PlayerRole::JESTER:
                if ($targetPlayer->id === $this->currentPlayer->id) return false;
                if ($this->currentPlayer->is_alive || $this->lobby->day_count !== $this->currentPlayer->death_night) return false;
                break;
            case PlayerRole::ANGEL:
                if ($targetPlayer->id !== $this->currentPlayer->id) return false;
                if ($this->currentPlayer->ability_uses === 0) return false;
                break;
            default:
                return false;
        }
        return true;
    }

    /**
     * Kills the target player and sets their death night.
     * @param Player $player The player who is targeted by the ability.
     * @return void
     */
    private function killPlayer(Player $player): void
    {
        $player->update([
            'is_alive' => false,
            'death_night' => $this->lobby->day_count,
        ]);
    }

    /**
     * Returns the action name of the player role for the button in the frontend
     * @return string
     */
    public function getAbilityName(): string
    {
        return match ($this->currentPlayer->role->enum) {
            PlayerRole::GODFATHER => 'Öldür',
            PlayerRole::MAFIOSO => 'Öldür',
            PlayerRole::JANITOR => 'Temizle',
            PlayerRole::DOCTOR => 'Koru',
            PlayerRole::GUARD => 'Sorgula',
            PlayerRole::LOOKOUT => 'Dikizle',
            PlayerRole::HUNTER => 'Vur',
            PlayerRole::WITCH => 'Zehirle',
            PlayerRole::JESTER => 'Lanetle',
            PlayerRole::ANGEL => 'Dönüş',
        };
    }

    /**
     * Send target player a message about the action they have taken.
     * @param Player $targetPlayer The player who is targeted by the action.
     * @return string The message to be sent to the player.
     */
    private function getActionMessage(Player $targetPlayer): string
    {
        $name = $targetPlayer->user->username;

        return match ($this->currentPlayer->role->enum) {
            PlayerRole::GODFATHER => "{$name} adlı oyuncunun öldürülmesi için emir verdin.",
            PlayerRole::MAFIOSO => "{$name} adlı oyuncuyu öldürme kararı aldın.",
            PlayerRole::JANITOR => "{$name} adlı oyuncunun cesedini temizlemeye karar verdin.",
            PlayerRole::DOCTOR => "{$name} adlı oyuncuyu koruma kararı aldın.",
            PlayerRole::GUARD => "{$name} adlı oyuncuya GBT sorgusu yapmaya karar verdin.",
            PlayerRole::LOOKOUT => "{$name} adlı oyuncunun evini dikizlemeye karar verdin.",
            PlayerRole::HUNTER => "{$name} adlı oyuncuyu vurmaya karar verdin.",
            PlayerRole::WITCH => "{$name} adlı oyuncuyu zehirlemeye karar verdin.",
            PlayerRole::JESTER => "{$name} adlı oyuncuyu lanetlemeye karar verdin.",
            PlayerRole::ANGEL => "Melek formuna dönüşmeye karar verdin."
        };
    }

    private function processPoisons()
    {
        $poisons = $this->lobby->poisons()->get();

        if ($poisons->count() === 0) return;

        foreach ($poisons as $poison) {
            // If the poison was not applied last night, skip
            if ($this->lobby->day_count !== $poison->poisoned_at + 1) continue;

            $targetPlayer = $this->lobby->players()->find($poison->target_id);

            if (!$targetPlayer) continue;

            $healActions = $this->lobby->actions()->where('action_type', ActionType::HEAL)->get();

            foreach ($healActions as $healAction) {
                if ($healAction->target_id === $targetPlayer->id) {
                    $this->sendMessageToPlayer($targetPlayer, 'Bir doktor sana panzehir verdi, zehirin etkisinden kurtuldun!', ChatMessageType::SUCCESS);
                    $poison->delete();
                    return;
                }
            }

            $this->killPlayer($targetPlayer);
            $this->sendMessageToPlayer($targetPlayer, 'Zehir etkisinden öldün!', ChatMessageType::WARNING);
            $poison->delete();
        }
    }

    private function processGuilts()
    {
        $guilts = $this->lobby->guilts()->with('player')->get();

        if ($guilts->count() === 0) return;

        foreach ($guilts as $guilt) {
            // If the guilt was not applied last night, skip
            if ($this->lobby->day_count !== $guilt->night) continue;

            $guiltyPlayer = $guilt->player;

            if (!$guiltyPlayer) continue;

            $this->killPlayer($guiltyPlayer);
            $this->sendMessageToPlayer($guiltyPlayer, 'Vicdan azabından intihar ettin!', ChatMessageType::WARNING);
            $guilt->delete();
        }
    }

    private function sendNightAbilityMessages()
    {
        $players = $this->lobby->players()->with('role')->get();

        foreach ($players as $player) {
            if (!$player->is_alive || $player->role->enum === PlayerRole::VILLAGER) {
                continue;
            }
            $availableUses = $player->ability_uses;
            if ($availableUses === null) {
                $msg = "Yeteneğinizi kullanabilirsiniz.";
            } else {
                if ($availableUses > 0) {
                    $msg = match ($player->role->enum) {
                        PlayerRole::HUNTER => "Silahında {$availableUses} tane mermi var.",
                        PlayerRole::WITCH => "Dolapta hazır {$availableUses} adet zehir var.",
                        PlayerRole::ANGEL => "{$availableUses} kere melek formuna dönüşebilirsin.",
                        PlayerRole::JANITOR => "Sadece {$availableUses} ceset temizlemeye yetecek kadar malzemen var.",
                    };
                } elseif ($availableUses === 0) {
                    $msg = match ($player->role->enum) {
                        PlayerRole::HUNTER => "Bütün mermilerini kullandın. Artık dinlenebilirsin.",
                        PlayerRole::WITCH => "Başka zehirin kalmadı. Beklemek dışında yapacak bir şeyin yok.",
                        PlayerRole::ANGEL => "Artık insan formunda kısılıp kaldın. Melek formuna dönüşemezsin.",
                        PlayerRole::JANITOR => "Malzemelerin tükendi. Artık temizlik yapamazsın.",
                    };
                }
            }

            if ($player->role->enum === PlayerRole::JESTER) {
                if (!$player->is_alive && $player->death_night === $this->lobby->day_count) {
                    $msg = "Kasabadaki herkesi kandırdın ve kendini idam ettirdin. Şimdi birini lanetleyebilirsin.";
                } else {
                    continue;
                }
            }

            $this->sendMessageToPlayer($player, $msg);
        }
    }

    private function getCancelActionMessage(Player $targetPlayer): string
    {
        $name = $targetPlayer->user->username;

        return match ($this->currentPlayer->role->enum) {
            PlayerRole::GODFATHER => "{$name} adlı oyuncuyu öldürme emrini iptal ettin.",
            PlayerRole::MAFIOSO => "{$name} adlı oyuncuyu öldürmemeye karar verdin.",
            PlayerRole::JANITOR => "{$name} adlı oyuncunun cesedini temizlemekten vazgeçtin.",
            PlayerRole::DOCTOR => "{$name} adlı oyuncuyu korumaktan vazgeçtin.",
            PlayerRole::GUARD => "{$name} adlı oyuncuya GBT sorgusu yapmaktan vazgeçtin.",
            PlayerRole::LOOKOUT => "{$name} adlı oyuncunun evini dikizlemekten vazgeçtin.",
            PlayerRole::HUNTER => "{$name} adlı oyuncuyu vurmamaya karar verdin.",
            PlayerRole::WITCH => "{$name} adlı oyuncuyu zehirlemekten vazgeçtin.",
            PlayerRole::JESTER => "{$name} adlı oyuncuyu lanetlemekten vazgeçtin.",
            PlayerRole::ANGEL => "Melek formuna dönüşmekten vazgeçtin."
        };
    }

    /**
     * Gets the action type that the current player can perform based on their role.
     * @return ActionType The action type that the player can perform.
     */
    private function getActionType(): ActionType
    {
        return match ($this->currentPlayer->role->enum) {
            PlayerRole::GODFATHER => ActionType::ORDER,
            PlayerRole::MAFIOSO => ActionType::KILL,
            PlayerRole::JANITOR => ActionType::CLEAN,
            PlayerRole::DOCTOR => ActionType::HEAL,
            PlayerRole::GUARD => ActionType::INTERROGATE,
            PlayerRole::LOOKOUT => ActionType::WATCH,
            PlayerRole::HUNTER => ActionType::SHOOT,
            PlayerRole::ANGEL => ActionType::REVEAL,
            PlayerRole::WITCH => ActionType::POISON,
            PlayerRole::JESTER => ActionType::HAUNT,
            PlayerRole::ANGEL => ActionType::REVEAL,
        };
    }

    /**
     * Checks if the current player has used their ability on the target player.
     * @param Player $targetPlayer The player who is targeted by the ability.
     * @return bool True if the player has used ability, false otherwise.
     */
    public function hasUsedAbility(Player $targetPlayer): bool
    {
        return $this->lobby->actions()->where([
            'actor_id' => $this->currentPlayer->id,
            'target_id' => $targetPlayer->id,
        ])->exists();
    }
}
