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
        $this->gameRoles = GameRole::select('id', 'name', 'icon', 'enum')->get();
    }

    public function isUnique(PlayerRole $role): bool
    {
        return in_array($role, PlayerRole::getUniqueRoles());
    }

    public function loadPreset(string $preset)
    {
        // Clear current selection
        $this->selectedRoles = [];

        switch ($preset) {
            case 'classic':
                $this->loadClassicGame();
                break;
            case 'balanced':
                $this->loadBalancedGame();
                break;
            case 'chaos':
                $this->loadChaosGame();
                break;
            case 'beginner':
                $this->loadBeginnerGame();
                break;
            default:
                Toaster::error('Geçersiz oyun türü seçildi.');
                break;
        }
    }

    private function loadClassicGame()
    {
        $roles = [
            // 1 Godfather
            PlayerRole::GODFATHER->value => 1,
            // 1 Mafioso
            PlayerRole::MAFIOSO->value => 1,
            // 1 Janitor
            PlayerRole::JANITOR->value => 1,
            // 1 Doctor
            PlayerRole::DOCTOR->value => 1,
            // 1 Lookout
            PlayerRole::LOOKOUT->value => 1,
            // 1 Guard
            PlayerRole::GUARD->value => 1,
            // 1 Hunter
            PlayerRole::HUNTER->value => 1,
            // 2 Villagers
            PlayerRole::VILLAGER->value => 3,
        ];

        $this->addRolesToSelection($roles);
        Toaster::success('Klasik oyun seti yüklendi.');
    }

    private function loadBalancedGame()
    {
        $roles = [
            // 1 Godfather
            PlayerRole::GODFATHER->value => 1,
            // 1 Mafioso
            PlayerRole::MAFIOSO->value => 1,
            // 1 Janitor
            PlayerRole::JANITOR->value => 1,
            // 1 Doctor
            PlayerRole::DOCTOR->value => 1,
            // 1 Lookout
            PlayerRole::LOOKOUT->value => 1,
            // 1 Guard
            PlayerRole::GUARD->value => 1,
            // 1 Hunter
            PlayerRole::HUNTER->value => 1,
            // 1 Jester
            PlayerRole::JESTER->value => 1,
            // 1 Angel
            PlayerRole::ANGEL->value => 1,
            // 3 Villagers
            PlayerRole::VILLAGER->value => 3,
        ];

        $this->addRolesToSelection($roles);
        Toaster::success('Dengeli oyun seti yüklendi.');
    }

    private function loadChaosGame()
    {
        $roles = [
            // 1 Godfather
            PlayerRole::GODFATHER->value => 1,
            // 1 Mafioso
            PlayerRole::MAFIOSO->value => 1,
            // 2 Janitor
            PlayerRole::JANITOR->value => 2,
            // 1 Witch
            PlayerRole::WITCH->value => 1,
            // 2 Doctor
            PlayerRole::DOCTOR->value => 2,
            // 1 Lookout
            PlayerRole::LOOKOUT->value => 1,
            // 1 Hunter
            PlayerRole::HUNTER->value => 1,
            // 1 Angel
            PlayerRole::ANGEL->value => 1,
            // 2 Jester
            PlayerRole::JESTER->value => 2,
            // 3 Villagers
            PlayerRole::VILLAGER->value => 3,
        ];

        $this->addRolesToSelection($roles);
        Toaster::success('Kaos oyun seti yüklendi.');
    }

    private function loadBeginnerGame()
    {
        $roles = [
            // 1 Godfather
            PlayerRole::GODFATHER->value => 1,
            // 1 Mafioso
            PlayerRole::MAFIOSO->value => 1,
            // 1 Doctor
            PlayerRole::DOCTOR->value => 1,
            // 1 Lookout
            PlayerRole::LOOKOUT->value => 1,
            // 1 Jester
            PlayerRole::JESTER->value => 1,
            // 2 Villagers
            PlayerRole::VILLAGER->value => 2,
        ];

        $this->addRolesToSelection($roles);
        Toaster::success('Başlangıç oyun seti yüklendi.');
    }

    private function addRolesToSelection(array $roleCounts)
    {
        foreach ($roleCounts as $roleValue => $count) {
            $role = $this->gameRoles->firstWhere('enum', $roleValue);

            if ($role) {
                for ($i = 0; $i < $count; $i++) {
                    $roleClone = clone $role;
                    $roleClone = $roleClone->toArray();
                    $roleClone['uuid'] = uniqid();
                    $this->selectedRoles[] = $roleClone;
                }
            }
        }
    }

    public function createLobby()
    {
        $messages = [
            'lobbyName.required' => 'Oda adı zorunludur.',
            'lobbyName.min' => 'Oda adı en az :min karakter olmalıdır.',
            'lobbyName.max' => 'Oda adı en fazla :max karakter olmalıdır.',
        ];

        try {
            $this->validate([
                'lobbyName' => 'required|min:3|max:35',
            ], $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Toaster::error($e->validator->errors()->first());
            return;
        }


        if (count($this->selectedRoles) < 7) {
            Toaster::error('En az 7 rol seçmelisiniz.');
            //return;
        }

        if (count($this->selectedRoles) > 15) {
            Toaster::error('En fazla 15 rol seçebilirsiniz.');
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

        // Atleast one mafia role (either mafioso or godfather) must be selected
        $mafiaRoles = $this->gameRoles->filter(fn($role) => in_array($role->enum, PlayerRole::getMafiaRoles()))->pluck('id');
        $mafiaRoleCount = $roleIds->filter(fn($id) => $mafiaRoles->contains($id))->count();
        if ($mafiaRoleCount < 1) {
            Toaster::error('En az bir mafya rolü seçmelisiniz.');
            return;
        }
        // Atleast 2 town roles must be selected
        $townRoles = $this->gameRoles->filter(fn($role) => in_array($role->enum, PlayerRole::getTownRoles()))->pluck('id');
        $townRoleCount = $roleIds->filter(fn($id) => $townRoles->contains($id))->count();
        if ($townRoleCount < 2) {
            Toaster::error('En az 2 kasaba rolü seçmelisiniz.');
            return;
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
        return view('livewire.zalim-kasaba.create-lobby')->title('Yeni Zalim Kasaba Oyunu - Gazi Social');
    }
}
