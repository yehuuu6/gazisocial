<?php

namespace App\Livewire\ZalimKasaba;

use App\Enums\ZalimKasaba\PlayerRole;
use Masmerise\Toaster\Toaster;
use App\Models\ZalimKasaba\Lobby;
use App\Models\ZalimKasaba\GameRole;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class CreateLobby extends Component
{
    public string $lobbyName;
    public array $selectedRoles = [];
    public Collection $gameRoles;
    public bool $rolesHidden = false;

    public function mount()
    {
        $this->gameRoles = GameRole::all();
    }

    public function isUnique(PlayerRole $role): bool
    {
        return in_array($role, PlayerRole::getUniqueRoles());
    }

    public function createLobby()
    {
        $messages = [
            'lobbyName.required' => 'Lobi adı zorunludur.',
            'lobbyName.min' => 'Lobi adı en az :min karakter olmalıdır.',
            'lobbyName.max' => 'Lobi adı en fazla :max karakter olmalıdır.',
        ];

        try {
            $this->validate([
                'lobbyName' => 'required|min:3|max:35',
            ], $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Toaster::error($e->validator->errors()->first());
            return;
        }

        // Only get the ids of the selected roles
        $roleIds = collect($this->selectedRoles)->map(fn($role) => $role['id']);

        // Get the unique roles
        $uniqueRoles = $this->gameRoles->filter(fn($role) => in_array($role->enum, PlayerRole::getUniqueRoles()))->pluck('id');

        // Check if any unique role is selected more than once
        foreach ($uniqueRoles as $uniqueRoleId) {
            if ($roleIds->filter(fn($id) => $id === $uniqueRoleId)->count() > 1) {
                Toaster::error('Özel roller bir defa seçilebilir.');
                return;
            }
        }

        $lobby = Lobby::create([
            'host_id' => Auth::id(),
            'name' => $this->lobbyName,
            'max_players' => $roleIds->count(),
            'roles_hidden' => $this->rolesHidden,
        ]);

        $lobby->roles()->attach($roleIds);

        return redirect()->route('games.zk.show', $lobby->uuid)->success('Lobi başarıyla oluşturuldu.');
    }

    #[Layout('layout.games')]
    public function render()
    {
        return view('livewire.zalim-kasaba.create-lobby');
    }
}
