<?php

namespace App\Traits\ZalimKasaba;

use App\Enums\ZalimKasaba\ActionType;
use App\Enums\ZalimKasaba\PlayerRole;
use App\Enums\ZalimKasaba\ChatMessageType;
use Masmerise\Toaster\Toaster;

trait RoleActions
{
    use ChatManager, PlayerActionsManager;

    private function godfatherActions()
    {
        $players = $this->lobby->players()->get();
        $actions = $this->lobby->actions()->with(['target', 'actor'])->get();

        // Find the godfather
        $godfather = $players->where('role.enum', PlayerRole::GODFATHER)
            ->where('is_alive', true)
            ->first();

        if (!$godfather) return; // If the godfather is dead, return

        // Find the order action of the godfather
        $orderAction = $actions->where('action_type', ActionType::ORDER)
            ->where('actor_id', $godfather->id)
            ->first();

        if (!$orderAction) return; // If the godfather has no order action, return

        if ($orderAction->is_roleblocked) {
            $this->sendMessageToPlayer(
                $orderAction->actor,
                'Bekçi seni durdurdu ve kimlik kontrolü yaptı. Geceyi evde geçireceksin.',
                ChatMessageType::WARNING
            );
            return;
        };

        // Find the mafioso
        $mafioso = $players->where('role.enum', PlayerRole::MAFIOSO)
            ->where('is_alive', true)
            ->first();

        if ($mafioso) {
            // Delete the mafioso's KILL action, if there is any
            $mafiosoKillAction = $actions->where('action_type', ActionType::KILL)
                ->where('actor_id', $mafioso->id)
                ->first();

            if ($mafiosoKillAction) {
                $mafiosoKillAction->delete();
            }

            // Update the order action, so the mafioso obeys the godfather
            $orderAction->update([
                'actor_id' => $mafioso->id,
                'action_type' => ActionType::KILL,
            ]);

            $this->sendMessageToPlayer($mafioso, 'Baronun emri üzerine hedefine saldırdın.', ChatMessageType::DEFAULT);
        } else {
            // If there is no mafioso, the godfather will kill the target himself
            $orderAction->update([
                'action_type' => ActionType::KILL,
            ]);

            // Get heal actions
            $healActions = $actions->where('action_type', ActionType::HEAL);

            // If the target is healed, the kill action will be cancelled
            foreach ($healActions as $healAction) {
                if ($healAction->target_id === $orderAction->target_id) {
                    $this->sendMessageToPlayer($godfather, 'Hedefinize saldırdınız, ancak biri onu geri hayata döndürdü!', ChatMessageType::WARNING);
                    $this->sendMessageToPlayer($healAction->actor, 'Hedefiniz saldırıya uğradı, ancak onu kurtardınız!', ChatMessageType::SUCCESS);
                    $this->sendMessageToPlayer($healAction->target, 'Biri evine girip sana saldırdı, ama bir doktor seni kurtardı!', ChatMessageType::SUCCESS);
                    return;
                }
            }

            $this->killPlayer($orderAction->target);
            $this->sendMessageToPlayer(
                $orderAction->target,
                'Biri evine girdi, öldürüldün!',
                ChatMessageType::WARNING
            );
        }
    }

    private function mafiosoActions()
    {
        $players = $this->lobby->players()->get();
        $actions = $this->lobby->actions()->with(['target', 'actor'])->get();

        // Find the mafioso if no order action found. (Mafioso will decide to kill or not)
        $mafioso = $players->where('role.enum', PlayerRole::MAFIOSO)
            ->where('is_alive', true)
            ->first();

        if (!$mafioso) return; // If the mafioso is dead, return

        // Find the kill action of the mafioso
        $killAction = $actions->where('action_type', ActionType::KILL)
            ->where('actor_id', $mafioso->id)
            ->first();

        if (!$killAction) return; // If the mafioso has no kill action, return

        $guardActionForMe = $actions->where('action_type', ActionType::INTERROGATE)
            ->where('target_id', $killAction->actor_id)
            ->first();

        if ($killAction->is_roleblocked || $guardActionForMe) {
            $this->sendMessageToPlayer(
                $killAction->actor,
                'Bekçi seni durdurdu ve kimlik kontrolü yaptı. Geceyi evde geçireceksin.',
                ChatMessageType::WARNING
            );
            return;
        };

        // Get heal actions
        $healActions = $actions->where('action_type', ActionType::HEAL);

        // If the target is healed, the kill action will be cancelled
        foreach ($healActions as $healAction) {
            if ($healAction->target_id === $killAction->target_id) {
                $this->sendMessageToPlayer($mafioso, 'Hedefine saldırdın, ancak biri onu geri hayata döndürdü!', ChatMessageType::WARNING);
                $this->sendMessageToPlayer($healAction->actor, 'Hedefin saldırıya uğradı, ancak onu kurtardın!', ChatMessageType::SUCCESS);
                $this->sendMessageToPlayer($healAction->target, 'Saldırıya uğradın ama biri seni tekrar hayata döndürdü!', ChatMessageType::SUCCESS);
                return;
            }
        }

        $this->killPlayer($killAction->target);
        $this->sendMessageToPlayer($killAction->target, 'Biri evine girdi, öldürüldün!', ChatMessageType::WARNING);
    }

    private function janitorActions()
    {
        $players = $this->lobby->players()->get();
        $actions = $this->lobby->actions()->with(['target', 'actor'])->get();

        $janitors = $players->where('role.enum', PlayerRole::JANITOR)->where('is_alive', true);

        if ($janitors->count() === 0) return;

        $cleanActions = $actions->where('action_type', ActionType::CLEAN);

        if ($cleanActions->count() === 0) return;

        foreach ($cleanActions as $cleanAction) {
            if ($cleanAction->is_roleblocked) {
                $this->sendMessageToPlayer(
                    $cleanAction->actor,
                    'Bekçi seni durdurdu ve kimlik kontrolü yaptı. Geceyi evde geçireceksin.',
                    ChatMessageType::WARNING
                );
                continue;
            };

            if ($cleanAction->actor->ability_uses === 0) continue; // If the janitor has no ability uses, skip

            // Update every cleaned player's is_cleaned column
            $cleanedPlayer = $players->firstWhere('id', $cleanAction->target_id);
            if ($cleanedPlayer) {
                $cleanedPlayer->update(['is_cleaned' => true]);
            }
        }
    }

    private function doctorActions()
    {
        $players = $this->lobby->players()->get();
        $actions = $this->lobby->actions()->with(['target', 'actor'])->get();

        $doctors = $players->where('role.enum', PlayerRole::DOCTOR)->where('is_alive', true);

        if ($doctors->count() === 0) return;

        $healActions = $actions->where('action_type', ActionType::HEAL);

        if ($healActions->count() === 0) return;

        // If the doctors heal themselves, update the players self_healed column
        foreach ($healActions as $healAction) {
            if ($healAction->is_roleblocked) {
                $this->sendMessageToPlayer(
                    $healAction->actor,
                    'Bekçi seni durdurdu ve kimlik kontrolü yaptı. Geceyi evde geçireceksin.',
                    ChatMessageType::WARNING
                );
                continue;
            };

            if ($healAction->actor_id === $healAction->target_id) {
                $healer = $players->firstWhere('id', $healAction->actor_id);
                $healer->update(['self_healed' => true]);
            }
        }
    }

    private function lookoutActions()
    {
        $players = $this->lobby->players()->get();
        $actions = $this->lobby->actions()->with(['target', 'actor'])->get();

        $lookouts = $players->where('role.enum', PlayerRole::LOOKOUT)->where('is_alive', true);
        if ($lookouts->isEmpty()) return;

        $watchActions = $actions->where('action_type', ActionType::WATCH);
        if ($watchActions->isEmpty()) return;

        // Re-fetch all actions from the database to ensure up-to-date data
        $actions = $this->lobby->actions()->with(['target', 'actor'])->get();

        foreach ($watchActions as $watchAction) {
            if ($watchAction->is_roleblocked) {
                $this->sendMessageToPlayer(
                    $watchAction->actor,
                    'Bekçi seni durdurdu ve kimlik kontrolü yaptı. Geceyi evde geçireceksin.',
                    ChatMessageType::WARNING
                );
                continue;
            };

            $watcher = $players->firstWhere('id', $watchAction->actor_id);
            $actionsOnWatchedPlayer = $actions
                ->where('target_id', $watchAction->target_id)
                ->where('actor_id', '!=', $watcher->id);

            $visitors = $actionsOnWatchedPlayer->map(fn($action) => $players->firstWhere('id', $action->actor_id))
                ->filter() // Remove null entries
                ->unique('id'); // Avoid duplicate visitors

            $visitorNames = $visitors->map(fn($visitor) => $visitor->user->username);

            if ($visitorNames->isNotEmpty()) {
                $this->sendMessageToPlayer(
                    $watcher,
                    'Hedefin ' . $visitorNames->implode(', ') . ' tarafından ziyaret edildi.',
                    ChatMessageType::DEFAULT
                );
            } else {
                $this->sendMessageToPlayer(
                    $watcher,
                    'Hedefin bu gece kimse tarafından ziyaret edilmedi.',
                    ChatMessageType::DEFAULT
                );
            }
        }
    }

    private function guardActions()
    {
        $players = $this->lobby->players()->get();
        $actions = $this->lobby->actions()->with(['target', 'actor'])->get();

        $guards = $players->where('role.enum', PlayerRole::GUARD)->where('is_alive', true);

        if ($guards->count() === 0) return;

        $guardActions = $actions->where('action_type', ActionType::INTERROGATE);

        if ($guardActions->count() === 0) return;

        foreach ($guardActions as $guardAction) {
            if ($guardAction->is_roleblocked) {
                $this->sendMessageToPlayer(
                    $guardAction->actor,
                    'Bir bekçi seni sorgulamaya geldi, ancak meslektaşın olduğunu anladı ve selam verip gitti.',
                    ChatMessageType::DEFAULT
                );
            }
            $targetPlayer = $players->firstWhere('id', $guardAction->target_id);

            // Find the target players action
            $targetAction = $actions->where('actor_id', $targetPlayer->id)->first();
            if (!$targetAction) {
                $this->sendMessageToPlayer(
                    $targetPlayer,
                    'Kapının önünde bekçi dolanıyor, neyseki bugün evde kalmayı tercih ettin.',
                    ChatMessageType::WARNING
                );
                continue;
            }

            // Update the target player action's is_roleblocked column
            $targetAction->update(['is_roleblocked' => true]);
        }
    }

    private function hunterActions()
    {
        $players = $this->lobby->players()->get();
        $actions = $this->lobby->actions()->with(['target', 'actor'])->get();

        $hunters = $players->where('role.enum', PlayerRole::HUNTER)->where('is_alive', true);

        if ($hunters->count() === 0) return;

        $shootActions = $actions->where('action_type', ActionType::SHOOT);

        if ($shootActions->count() === 0) return;

        $healActions = $actions->where('action_type', ActionType::HEAL);

        foreach ($shootActions as $shootAction) {
            if ($shootAction->is_roleblocked) {
                $this->sendMessageToPlayer(
                    $shootAction->actor,
                    'Bekçi seni durdurdu ve kimlik kontrolü yaptı. Geceyi evde geçireceksin.',
                    ChatMessageType::WARNING
                );
                continue;
            };

            $hunter = $shootAction->actor;

            if ($hunter->ability_uses === 0) continue;

            foreach ($healActions as $healAction) {
                if ($healAction->target_id === $shootAction->target_id) {
                    $this->sendMessageToPlayer($hunter, 'Hedefine ateş ettin, ancak biri onu geri hayata döndürdü!', ChatMessageType::WARNING);
                    $this->sendMessageToPlayer($healAction->actor, 'Hedefin saldırıya uğradı, ancak onu kurtardın!', ChatMessageType::SUCCESS);
                    $this->sendMessageToPlayer($healAction->target, 'Biri evine girip sana saldırdı, ama bir doktor seni kurtardı!', ChatMessageType::SUCCESS);
                    return;
                }
            }

            $this->killPlayer($shootAction->target);
            $this->sendMessageToPlayer($shootAction->target, 'Biri evine girdi, öldürüldün!', ChatMessageType::WARNING);

            // If the target player is a townie, the hunter will die as well
            if (in_array($shootAction->target->role->enum, PlayerRole::getTownRoles())) {
                // Create a guilt model
                $this->lobby->guilts()->create([
                    'player_id' => $hunter->id,
                    'night' => $this->lobby->day_count + 1,
                ]);
            }
        }
    }

    private function witchActions()
    {
        $players = $this->lobby->players()->get();
        $actions = $this->lobby->actions()->with(['target', 'actor'])->get();

        $witch = $players->where('role.enum', PlayerRole::WITCH)->where('is_alive', true)->first();

        if (!$witch || $witch->ability_uses === 0) return;

        $poisonAction = $actions->where('action_type', ActionType::POISON)->where('actor_id', $witch->id)->first();

        if (!$poisonAction) return;

        if ($poisonAction->is_roleblocked) {
            $this->sendMessageToPlayer(
                $poisonAction->actor,
                "Bekçi seni durdurdu ve kimlik kontrolü yaptı. Geceyi evde geçireceksin.",
                ChatMessageType::WARNING
            );
            return;
        }

        $targetPlayer = $players->firstWhere('id', $poisonAction->target_id);

        $poison = $this->lobby->poisons()->create([
            'target_id' => $targetPlayer->id,
            'poisoner_id' => $witch->id,
            'poisoned_at' => $this->lobby->day_count,
        ]);

        $this->sendMessageToPlayer(
            $targetPlayer,
            'Bir cadı tarafından zehirlendin!',
            ChatMessageType::WARNING
        );
    }

    private function angelActions()
    {
        $players = $this->lobby->players()->get();
        $actions = $this->lobby->actions()->with(['target', 'actor'])->get();

        $angels = $players->where('role.enum', PlayerRole::ANGEL)->where('is_alive', true);

        if ($angels->count() === 0) return;

        $revealActions = $actions->where('action_type', ActionType::REVEAL);

        if ($revealActions->count() === 0) return;

        $orderActions = $actions->where('action_type', ActionType::ORDER);
        $killActions = $actions->where('action_type', ActionType::KILL);
        $shootActions = $actions->where('action_type', ActionType::SHOOT);
        $poisonActions = $actions->where('action_type', ActionType::POISON);

        // Merge the kill and shoot actions
        $deathActions = $killActions->merge($shootActions)->merge($poisonActions)->merge($orderActions);

        foreach ($revealActions as $revealAction) {
            $angel = $revealAction->actor;

            if ($angel->ability_uses === 0) continue;

            foreach ($deathActions as $deathAction) {
                if ($deathAction->target_id === $revealAction->target_id) {
                    // DELETING THIS CAUSES THE LOOKOUT TO NOT SEE THE ATTACKER
                    // ALSO SOMETIMES MESSAGES DONT GO TO PLAYERS ON EXIT NIGHT.
                    $deathAction->delete();
                    $this->sendMessageToPlayer($deathAction->actor, 'Öldürmek için gittiğin evde bir meleğin göz kamaştıran güzelliği seni durdurdu.', ChatMessageType::WARNING);
                    $this->sendMessageToPlayer($deathAction->target, 'Biri sana saldırmaya çalıştı, ama güzelliğin onu durdurdu!', ChatMessageType::SUCCESS);
                    return;
                }
            }
        }
    }

    private function jesterActions()
    {
        $players = $this->lobby->players()->get();
        $actions = $this->lobby->actions()->with(['target', 'actor'])->get();

        $jesters = $players->where('role.enum', PlayerRole::JESTER)->where('is_alive', false)->where('is_executed', true);

        if ($jesters->count() === 0) return;

        $hauntActions = $actions->where('action_type', ActionType::HAUNT);

        if ($hauntActions->count() === 0) return;

        foreach ($hauntActions as $hauntAction) {
            $jester = $hauntAction->actor;

            if ($jester->is_alive || $jester->death_night !== $this->lobby->day_count) continue;

            $this->killPlayer($hauntAction->target);
            $this->sendMessageToPlayer($hauntAction->target, 'Zibidi tarafından lanetlendin!', ChatMessageType::WARNING);
        }
    }

    // BUG ALERT!
    // IF DEAD PLAYERS USE CHAT AT NIGHT, THE REVEAL STATE DOES NOT
    // WORK PROPERLY, AND THE CHAT GOES DIRECTLY INTO THE NEW DAY CHAT.
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
}
