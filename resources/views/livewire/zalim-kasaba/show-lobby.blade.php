<div :class="{
    'h-[calc(100vh-16rem)]': !fullscreen,
    'h-full': fullscreen
}" x-data="{
    waitHostInterval: null,
    closeTimerTimeout: null,
    hostReturned() {
        clearInterval(this.waitHostInterval);
        clearTimeout(this.closeTimerTimeout);
        Toaster.success('Yönetici geri döndü.');
    },
    waitForHost() {
        let count = 30;
        Toaster.warning(`Yönetici oyundan ayrıldı. Bekleniyor... ${count}`);
        this.waitHostInterval = setInterval(() => {
            count = count - 5;
            Toaster.info(`Yönetici bekleniyor ${count}...`);
        }, 5000);
        this.closeTimerTimeout = setTimeout(() => {
            clearInterval(this.waitHostInterval);
            Toaster.error('Yönetici gelmedi. Oda kapatılıyor.');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }, 30000);
    },
}"
    x-on:host-left.window="waitForHost()" x-on:host-returned.window="hostReturned()">
    <div class="flex h-full rounded-xl">
        <div class="hidden lg:flex flex-col w-72 flex-shrink-0 border-r border-gray-200">
            @if ($lobby->state !== App\Enums\ZalimKasaba\GameState::LOBBY)
                <div class="flex-grow-0 bg-white p-4 border-b border-gray-200">
                    <h1 class="text-lg text-gray-800 font-semibold">
                        Mezarlık
                    </h1>
                    <ul class="mt-2 flex flex-col gap-2">
                        @forelse ($deadPlayers as $deadPlayer)
                            <li class="flex text-sm items-center justify-between w-full gap-2 rounded"
                                wire:key="dead-player-{{ $deadPlayer->id }}">
                                <span class="text-gray-600 font-medium"
                                    :class="{ 'line-through': {{ !$deadPlayer->is_online ? 'true' : 'false' }} }">
                                    🪦 {{ $deadPlayer->user->username }}
                                </span>
                                <span
                                    class="text-gray-500 text-xs font-medium px-1.5 py-0.5 rounded-full border border-gray-200">
                                    @if ($deadPlayer->is_cleaned)
                                        🧼 Temizlendi
                                    @else
                                        {{ $deadPlayer->role->icon . ' ' . $deadPlayer->role->name }}
                                    @endif
                                </span>
                            </li>
                        @empty
                            <li class="flex items-center gap-2 p-2 rounded">
                                <span class="text-gray-500 text-sm">
                                    Mezarlık boş.
                                </span>
                            </li>
                        @endforelse
                    </ul>
                </div>
            @endif
            <div class="flex flex-col flex-grow flex-shrink-0">
                <div class="bg-white flex flex-col h-full p-4">
                    <h1 class="text-lg text-gray-800 font-semibold">Rol Listesi</h1>
                    <ul class="flex flex-col gap-2 mt-1.5 flex-grow overflow-y-auto h-0">
                        @foreach ($lobby->roles as $role)
                            <li class="flex items-center justify-between p-2 gap-1 rounded"
                                wire:key="lobby-role-{{ $role->id }}">
                                <div>
                                    {{ $role->icon }}
                                    <span class="text-gray-800 font-normal ml-0.5">
                                        {{ $role->name }}
                                    </span>
                                </div>
                                <span class="text-xs font-medium px-1.5 py-0.5 rounded-full border border-gray-200"
                                    :class="{
                                        'text-red-500': '{{ $role->enum->getFaction() }}' ==
                                            'Mafya 🌹',
                                        'text-green-500': '{{ $role->enum->getFaction() }}' ==
                                            'Kasaba 🏘️',
                                        'text-purple-500': '{{ $role->enum->getFaction() }}' ==
                                            'Kaos 🌀',
                                        'text-yellow-500': '{{ $role->enum->getFaction() }}' ==
                                            'Tarafsız 🕊️'
                                    }">
                                    {{ $role->enum->getFaction() }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="flex flex-col flex-grow relative">
            <div class="flex bg-white items-center justify-between border-b border-gray-200 p-2" x-ref="gameHeader">
                <div class="flex items-center gap-2">
                    <x-ui.tooltip text="Tam Ekran" position="bottom">
                        <button type="button"
                            x-on:click="fullscreen = !fullscreen; Toaster.info('Tam ekran ' + (fullscreen ? 'moduna geçildi.' : 'modundan çıkıldı.'))"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center p-2 rounded">
                            <x-icons.fullscreen x-show="!fullscreen" x-cloak size="20" />
                            <x-icons.exit-fullscreen x-show="fullscreen" size="20" />
                        </button>
                    </x-ui.tooltip>
                    <x-ui.tooltip text="Ayarlar" position="bottom">
                        <button type="button"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center p-2 rounded">
                            <x-icons.cog size="20" />
                        </button>
                    </x-ui.tooltip>
                </div>
                <h1 class="text-gray-700 font-semibold text-lg" wire:text="gameTitle">
                </h1>
                <livewire:zalim-kasaba.show-game-timer :$lobby />
            </div>
            <div x-anchor.bottom-center.offset.15="$refs.gameHeader" wire:show="judgeModal" wire:cloak wire:transition
                class="shadow-lg rounded w-2/3 justify-between p-4 bg-white text-gray-600">
                <h1 class="text-center font-bold w-full text-xl text-gray-700">
                    Karar Ver
                </h1>
                <p class="text-center w-full mt-2">
                    <span class="text-yellow-500 font-bold">{{ $lobby->accused?->user->username }}</span> adlı
                    vatandaşımızın
                    kaderini belirleyin.
                </p>
                <div class="flex items-center gap-4 justify-evenly p-4 mt-2">
                    <button type="button" wire:click="finalVote('guilty')"
                        :class="{ 'outline outline-4 outline-red-300 shadow-lg shadow-red-400': {{ $this->hasVotedGuilty() ? 'true' : 'false' }} }"
                        class="bg-red-500 hover:bg-red-600 uppercase text-white rounded font-bold shadow px-4 py-2 transition duration-200 ease-out active:scale-90">
                        Suçlu
                    </button>
                    <button type="button" wire:click="finalVote('innocent')"
                        :class="{ 'outline outline-4 outline-green-300 shadow-lg shadow-green-400': {{ $this->hasVotedInno() ? 'true' : 'false' }} }"
                        class="bg-green-500 hover:bg-green-600 uppercase text-white rounded font-bold shadow px-4 py-2 transition duration-200 ease-out active:scale-90">
                        Masum
                    </button>
                </div>
            </div>
            <livewire:zalim-kasaba.chat-window :$lobby :$currentPlayer />
        </div>
        <div class="flex flex-col w-72 flex-shrink-0 border-l border-gray-200">
            @if ($this->lobby->state !== App\Enums\ZalimKasaba\GameState::LOBBY && $this->currentPlayer->role)
                <div x-data="{
                    isExpanded: true,
                    toggle() {
                        this.isExpanded = !this.isExpanded;
                    }
                }" class="overflow-y-auto border-b border-gray-200 bg-white p-4">
                    <h1 class="text-lg flex items-center justify-between gap-2 text-gray-800 font-semibold text-center">
                        {{ $this->currentPlayer->role->icon }}
                        <span
                            :class="{
                                'text-red-600': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                    'Mafya 🌹',
                                'text-green-600': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                    'Kasaba 🏘️',
                                'text-purple-500': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                    'Kaos 🌀',
                                'text-yellow-500': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                    'Tarafsız 🕊️',
                                'line-through': !{{ $this->currentPlayer->is_alive ? 'true' : 'false' }}
                            }"
                            class="font-bold">
                            @if (!$this->currentPlayer->is_alive)
                                👻
                            @endif
                            {{ $this->currentPlayer->role->name }}
                        </span>
                        <button type="button" x-on:click="toggle()" x-text="isExpanded ? '—' : '+'"
                            class="bg-gray-200 size-7 hover:bg-gray-100 text-gray-700 font-semibold px-1.5 py-0.5 text-xs rounded">
                            —
                        </button>
                    </h1>
                    <div x-show="isExpanded" x-collapse>
                        <p class="mt-2">
                            <span class="font-medium text-gray-700 text-sm">Taraf:</span>
                            <span class="text-sm font-bold"
                                :class="{
                                    'text-red-600': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                        'Mafya 🌹',
                                    'text-green-600': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                        'Kasaba 🏘️',
                                    'text-purple-500': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                        'Kaos 🌀',
                                    'text-yellow-500': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                        'Tarafsız 🕊️'
                                }">
                                {{ $this->currentPlayer->role->enum->getFaction() }}
                            </span>
                        </p>
                        <p>
                            <span class="font-medium text-gray-700 text-sm">
                                Amaç:
                            </span>
                            <span class="text-gray-500 text-xs">
                                {{ $this->currentPlayer->role->enum->getGoal() }}
                            </span>
                        </p>
                        <p>
                            <span class="font-medium text-gray-700 text-sm">Yetenek:</span>
                            <span class="text-gray-500 text-xs">
                                {{ $this->currentPlayer->role->enum->getDescription() }}
                            </span>
                        </p>
                    </div>
                </div>
            @endif
            <div class="flex flex-col flex-grow flex-shrink-0 bg-white p-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-lg text-gray-800 font-semibold">
                        @if ($lobby->state === App\Enums\ZalimKasaba\GameState::LOBBY)
                            Oyuncular
                        @else
                            Kasabalılar
                        @endif
                    </h1>
                    <span class="text-gray-500 text-sm font-medium">
                        {{ $lobby->players->count() }} / {{ $lobby->max_players }}
                    </span>
                </div>
                <ul class="flex flex-col gap-2 mt-1.5 flex-grow overflow-y-auto h-0">
                    @forelse ($lobby->players()->with(['user', 'role', 'votesReceived'])->orderBy('place')->where('is_alive', true)->get() as $player)
                        <li wire:key="player-{{ $player->id }}"
                            class="flex items-center justify-between gap-4 rounded-lg transition-colors">
                            <div class="flex items-center gap-1">
                                <span
                                    :class="{
                                        'bg-green-500': {{ $player->is_online }},
                                        'bg-red-500': !
                                            {{ $player->is_online }}
                                    }"
                                    class="flex items-center justify-center size-5 rounded-full text-white text-xs font-semibold">
                                    {{ $player->place }}
                                </span>
                                <span class="font-medium text-sm"
                                    :class="{
                                        'text-blue-700': {{ $player->id }} === {{ $currentPlayer->id }},
                                    }">
                                    {{ $player->user->username }}
                                </span>
                                <span class="text-gray-500 text-xs">
                                    @if ($player->is_host && $lobby->state === App\Enums\ZalimKasaba\GameState::LOBBY)
                                        👑
                                    @endif
                                    @if ($player->poison()->exists() && $this->currentPlayer->role->enum === App\Enums\ZalimKasaba\PlayerRole::WITCH)
                                        🧪
                                    @endif
                                    @if (
                                        $lobby->state !== App\Enums\ZalimKasaba\GameState::LOBBY &&
                                            in_array($player->role?->enum, App\Enums\ZalimKasaba\PlayerRole::getMafiaRoles()) &&
                                            in_array($currentPlayer->role?->enum, App\Enums\ZalimKasaba\PlayerRole::getMafiaRoles()))
                                        🌹
                                    @endif
                                    @if ($lobby->state === App\Enums\ZalimKasaba\GameState::VOTING)
                                        ({{ $player->votesReceived->count() }})
                                    @endif
                                </span>
                            </div>
                            @if (
                                $lobby->state === App\Enums\ZalimKasaba\GameState::LOBBY &&
                                    $currentPlayer->is_host &&
                                    $player->id !== $currentPlayer->id)
                                <button type="button" wire:click="kickPlayer({{ $player->id }})"
                                    class="bg-red-500 flex-shrink-0 hover:bg-red-600 text-white font-semibold px-1.5 py-0.5 text-xs rounded">
                                    KOV
                                </button>
                            @elseif ($this->canBeVoted($player))
                                <button type="button" wire:click="votePlayer({{ $player->id }})"
                                    class="bg-gray-100 flex-shrink-0 hover:bg-gray-200 text-gray-700 font-semibold px-1.5 py-0.5 text-xs rounded">
                                    @if ($this->hasVoted($player))
                                        İPTAL
                                    @else
                                        OY VER
                                    @endif
                                </button>
                            @elseif ($this->canUseAbility($player))
                                <button type="button" flex-shrink-0 wire:click="selectTarget({{ $player->id }})"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-1.5 py-0.5 text-xs rounded">
                                    @if ($this->hasUsedAbility($player))
                                        İPTAL
                                    @else
                                        {{ $this->getAbilityName() }}
                                    @endif
                                </button>
                            @endif
                        </li>
                    @empty
                        <li class="flex items-center gap-2 p-2 hover:bg-gray-50 rounded">
                            <span class="text-gray-800 font-semibold">Henüz kimse katılmadı.</span>
                        </li>
                    @endforelse
                </ul>
                @if ($currentPlayer->is_host && $lobby->state === App\Enums\ZalimKasaba\GameState::LOBBY)
                    <button wire:click="startGame" type="button"
                        class="bg-blue-500 hover:bg-blue-600 text-white rounded p-2 font-bold text-xl">
                        Oyunu Başlat
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
