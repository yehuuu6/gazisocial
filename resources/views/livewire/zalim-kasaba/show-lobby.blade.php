<div :class="{
    'h-[calc(100dvh-2rem)] lg:h-[calc(100dvh-16rem)]': !fullscreen,
    'h-full': fullscreen
}"
    x-data="{
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
    }" x-on:host-left.window="waitForHost()" x-on:host-returned.window="hostReturned()">
    <div class="flex h-full rounded-xl shadow-sm border border-gray-200 overflow-hidden" x-data="{
        leftPanel: false,
        rightPanel: false,
    }">
        <div :class="{
            '-left-80': !leftPanel,
            'left-0': leftPanel,
        }" x-cloak
            class="fixed transform w-72 lg:w-80 h-full transition-all duration-300 top-0 lg:static z-30 flex flex-col flex-shrink-0 bg-white border-r border-gray-200">
            @if ($lobby->state !== App\Enums\ZalimKasaba\GameState::LOBBY)
                <div class="bg-white p-4 border-b border-gray-200">
                    <div class="bg-gradient-to-r from-gray-700 to-gray-600 text-white rounded px-3 py-2 mb-3">
                        <h1 class="text-base md:text-lg font-semibold flex items-center gap-2">
                            <x-icons.skull size="18" />
                            Mezarlık
                        </h1>
                    </div>
                    <ul class="mt-2 flex flex-col gap-2">
                        @forelse ($deadPlayers as $deadPlayer)
                            <li wire:key="dead-player-{{ $deadPlayer->id }}">
                                <x-ui.tooltip text="Vasiyeti Gör" position="right">
                                    <button type="button"
                                        x-on:click="$dispatch('show-last-will', { playerId: {{ $deadPlayer->id }} }); $wire.showPlayerLastWill = true;"
                                        class="flex text-sm hover:bg-gray-50 items-center justify-between w-full gap-2 px-3 py-2 rounded-lg border border-gray-100 shadow-sm transition-all">
                                        <span class="text-gray-600 font-medium flex items-center gap-1"
                                            :class="{ 'line-through': {{ !$deadPlayer->is_online ? 'true' : 'false' }} }">
                                            <span class="text-lg">🪦</span> {{ $deadPlayer->user->username }}
                                        </span>
                                        <span
                                            class="text-gray-500 text-xs font-medium px-1.5 py-0.5 rounded-full bg-gray-50 border border-gray-200">
                                            @if ($deadPlayer->is_cleaned)
                                                🧼 Temizlendi
                                            @else
                                                {{ $deadPlayer->role->icon . ' ' . $deadPlayer->role->name }}
                                            @endif
                                        </span>
                                    </button>
                                </x-ui.tooltip>
                            </li>
                        @empty
                            <li class="text-center py-4 text-gray-500 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-xl">😇</span>
                                <p class="text-sm mt-1">Henüz kimse ölmedi.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            @endif
            <button type="button"
                class="lg:hidden absolute top-2 right-2 bg-gray-100 hover:bg-gray-200 text-gray-700 p-1 rounded-full shadow-sm"
                x-on:click="leftPanel = false">
                <x-icons.close size="20" />
            </button>
            <div class="flex flex-col flex-grow flex-shrink-0">
                <div class="bg-white flex flex-col h-full p-4">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded px-3 py-2 mb-3">
                        <h1 class="text-base md:text-lg font-semibold flex items-center gap-2">
                            <x-icons.tag size="18" />
                            Rol Listesi
                        </h1>
                    </div>
                    <ul class="flex flex-col gap-2 mt-1.5 flex-grow overflow-y-auto h-0">
                        @foreach ($lobby->roles as $role)
                            <li class="flex items-center justify-between p-2 gap-1 rounded-lg border border-gray-100 shadow-sm bg-white"
                                wire:key="lobby-role-{{ $role->id }}">
                                <div class="text-sm flex items-center gap-1">
                                    <span class="text-xl">{{ $role->icon }}</span>
                                    <span class="text-gray-800 font-medium">
                                        {{ $role->name }}
                                    </span>
                                </div>
                                <span class="text-xs font-medium px-2 py-1 rounded-full"
                                    :class="{
                                        'bg-red-50 text-red-600 border border-red-200': '{{ $role->enum->getFaction() }}' ==
                                            'Mafya 🌹',
                                        'bg-green-50 text-green-600 border border-green-200': '{{ $role->enum->getFaction() }}' ==
                                            'Kasaba 🏘️',
                                        'bg-purple-50 text-purple-600 border border-purple-200': '{{ $role->enum->getFaction() }}' ==
                                            'Kaos 🌀',
                                        'bg-yellow-50 text-yellow-600 border border-yellow-200': '{{ $role->enum->getFaction() }}' ==
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
            <div class="flex bg-white items-center justify-between border-b border-gray-200 p-3" x-ref="gameHeader">
                <div class="flex items-center gap-2">
                    <button type="button" x-on:click="leftPanel = true; rightPanel = false;"
                        class="lg:hidden bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center p-1 md:p-2 rounded-lg shadow-sm">
                        <x-icons.arrow-right-alt size="20" />
                    </button>
                    <x-ui.tooltip text="Tam Ekran" position="bottom">
                        <button type="button"
                            x-on:click="fullscreen = !fullscreen; Toaster.info('Tam ekran ' + (fullscreen ? 'moduna geçildi.' : 'modundan çıkıldı.'))"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center p-1 md:p-2 rounded-lg shadow-sm">
                            <x-icons.fullscreen x-show="!fullscreen" x-cloak size="20" />
                            <x-icons.exit-fullscreen x-show="fullscreen" size="20" />
                        </button>
                    </x-ui.tooltip>
                    @if (
                        $lobby->state !== App\Enums\ZalimKasaba\GameState::LOBBY &&
                            $lobby->state !== App\Enums\ZalimKasaba\GameState::PREPARATION)
                        <x-ui.tooltip text="Vasiyetim" position="bottom">
                            <button type="button" x-on:click="$wire.showLastWill = true;"
                                class="bg-purple-50 hover:bg-purple-100 text-purple-700 flex items-center justify-center p-1 md:p-2 rounded-lg shadow-sm transition-all">
                                <x-icons.notebook-pen size="20" />
                            </button>
                        </x-ui.tooltip>
                    @endif
                </div>
                <h1 class="text-gray-800 font-bold text-sm md:text-lg lg:text-xl bg-gray-50 px-4 py-1 rounded-full shadow-sm border border-gray-200"
                    wire:text="gameTitle">
                </h1>
                <div class="flex items-center gap-2">
                    <livewire:zalim-kasaba.show-game-timer :$lobby />
                    <button type="button" x-on:click="rightPanel = true; leftPanel = false;"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 lg:hidden flex items-center justify-center p-1 md:p-2 rounded-lg shadow-sm">
                        <x-icons.arrow-left-alt size="20" />
                    </button>
                </div>
            </div>
            <div x-anchor.bottom-center.offset.15="$refs.gameHeader" wire:show="judgeModal" wire:cloak wire:transition
                class="shadow-lg rounded-lg w-2/3 justify-between p-5 bg-white text-gray-600 border border-gray-200">
                <div
                    class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-t-lg p-3 -mx-5 -mt-5 mb-4">
                    <h1 class="text-center font-bold w-full text-xl">
                        Karar Ver
                    </h1>
                </div>
                <p class="text-center w-full mb-4">
                    <span class="text-orange-600 font-bold">{{ $lobby->accused?->user->username }}</span> adlı
                    vatandaşımızın kaderini belirleyin.
                </p>
                <div class="flex items-center gap-4 justify-evenly p-4">
                    <button type="button" wire:click="finalVote('guilty')"
                        :class="{ 'outline outline-4 outline-red-300 shadow-lg shadow-red-400': {{ $this->hasVotedGuilty() ? 'true' : 'false' }} }"
                        class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 uppercase text-white rounded-lg font-bold shadow-sm px-5 py-3 transition duration-200 ease-out active:scale-90">
                        Suçlu
                    </button>
                    <button type="button" wire:click="finalVote('innocent')"
                        :class="{ 'outline outline-4 outline-green-300 shadow-lg shadow-green-400': {{ $this->hasVotedInno() ? 'true' : 'false' }} }"
                        class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 uppercase text-white rounded-lg font-bold shadow-sm px-5 py-3 transition duration-200 ease-out active:scale-90">
                        Masum
                    </button>
                </div>
            </div>
            <livewire:zalim-kasaba.chat-window :$lobby />
        </div>
        <div :class="{
            '-right-80': !rightPanel,
            'right-0': rightPanel,
        }" x-cloak
            class="fixed transform h-full w-80 transition-all duration-300 lg:static top-0 z-30 flex flex-col flex-shrink-0 bg-white border-l border-gray-200">
            @if ($this->lobby->state !== App\Enums\ZalimKasaba\GameState::LOBBY && $this->currentPlayer->role)
                <div class="overflow-y-auto border-b border-gray-200 bg-white p-4">
                    <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 text-white rounded px-3 py-2 mb-3">
                        <h1
                            class="text-base md:text-lg flex items-center justify-center gap-2 font-semibold text-center">
                            <span class="text-2xl">{{ $this->currentPlayer->role->icon }}</span>
                            <span class="font-bold">
                                {{ $this->currentPlayer->role->name }}
                                @if (!$this->currentPlayer->is_alive)
                                    <span class="text-red-200 text-xs lg:text-sm font-normal ml-1">
                                        (Ölü)
                                    </span>
                                @endif
                            </span>
                        </h1>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                        <p class="mb-2 flex items-center gap-2">
                            <span class="font-medium text-gray-700 text-sm">Taraf:</span>
                            <span class="text-sm font-bold px-2 py-0.5 rounded-full"
                                :class="{
                                    'bg-red-50 text-red-600 border border-red-200': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                        'Mafya 🌹',
                                    'bg-green-50 text-green-600 border border-green-200': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                        'Kasaba 🏘️',
                                    'bg-purple-50 text-purple-600 border border-purple-200': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                        'Kaos 🌀',
                                    'bg-yellow-50 text-yellow-600 border border-yellow-200': '{{ $this->currentPlayer->role->enum->getFaction() }}' ==
                                        'Tarafsız 🕊️'
                                }">
                                {{ $this->currentPlayer->role->enum->getFaction() }}
                            </span>
                        </p>
                        <div class="my-1">
                            <span class="font-medium text-gray-700 text-sm">
                                Amaç:
                            </span>
                            <p class="text-gray-600 text-xs bg-white p-2 rounded border border-gray-100">
                                {{ $this->currentPlayer->role->enum->getGoal() }}
                            </p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 text-sm">Yetenek:</span>
                            <p class="text-gray-600 text-xs bg-white p-2 rounded border border-gray-100">
                                {{ $this->currentPlayer->role->enum->getDescription() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            <button type="button"
                class="absolute lg:hidden top-2 left-2 bg-gray-100 hover:bg-gray-200 text-gray-700 p-1 rounded-full shadow-sm"
                x-on:click="rightPanel = false">
                <x-icons.close size="20" />
            </button>
            <div class="flex flex-col flex-grow flex-shrink-0 bg-white p-4">
                <div class="flex items-center justify-between">
                    <div class="bg-gradient-to-r from-green-600 to-green-500 text-white rounded px-3 py-2 mb-3 w-full">
                        <h1 class="text-base md:text-lg font-semibold flex items-center justify-between gap-2">
                            <span class="flex items-center gap-2">
                                <x-icons.user size="18" />
                                @if ($lobby->state === App\Enums\ZalimKasaba\GameState::LOBBY)
                                    Oyuncular
                                @else
                                    Kasabalılar
                                @endif
                            </span>
                            <span class="text-sm font-normal bg-white/20 px-2 py-0.5 rounded-full mt-1">
                                {{ $lobby->players->count() }} / {{ $lobby->max_players }}
                            </span>
                        </h1>
                    </div>
                </div>
                <ul class="flex flex-col gap-2 mt-1.5 flex-grow overflow-y-auto h-0">
                    @forelse ($lobby->players()->with(['user', 'role', 'votesReceived'])->orderBy('place')->where('is_alive', true)->get() as $player)
                        <li wire:key="player-{{ $player->id }}"
                            class="flex items-center justify-between gap-4 rounded-lg p-2 border border-gray-100 shadow-sm bg-white hover:bg-gray-50 transition-all">
                            <div class="flex items-center gap-2">
                                <span
                                    :class="{
                                        'bg-green-500': {{ $player->is_online }},
                                        'bg-red-500': !
                                            {{ $player->is_online }}
                                    }"
                                    class="flex items-center justify-center size-5 rounded-full text-white text-xs font-semibold">
                                    {{ $player->place }}
                                </span>
                                <div class="flex flex-col">
                                    <span class="font-medium text-xs md:text-sm"
                                        :class="{
                                            'text-blue-700': {{ $player->id }} === {{ $currentPlayer->id }},
                                        }">
                                        {{ $player->user->username }}
                                    </span>
                                    <span class="text-gray-500 text-xs flex items-center gap-1">
                                        @if ($player->is_host && $lobby->state === App\Enums\ZalimKasaba\GameState::LOBBY)
                                            <span class="text-yellow-500">👑 Yönetici</span>
                                        @endif
                                        @if ($player->poison()->exists() && $this->currentPlayer->role->enum === App\Enums\ZalimKasaba\PlayerRole::WITCH)
                                            <span class="text-purple-500">🧪 Zehirlenmiş</span>
                                        @endif
                                        @if (
                                            $lobby->state !== App\Enums\ZalimKasaba\GameState::LOBBY &&
                                                in_array($player->role?->enum, App\Enums\ZalimKasaba\PlayerRole::getMafiaRoles()) &&
                                                in_array($currentPlayer->role?->enum, App\Enums\ZalimKasaba\PlayerRole::getMafiaRoles()))
                                            <span class="text-red-500">🌹 Mafya</span>
                                        @endif
                                        @if ($lobby->state === App\Enums\ZalimKasaba\GameState::VOTING && $player->votesReceived->count() > 0)
                                            <span
                                                class="bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded-full border border-blue-200 text-xs font-medium">
                                                {{ $player->votesReceived->count() }} oy
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @if (
                                $lobby->state === App\Enums\ZalimKasaba\GameState::LOBBY &&
                                    $currentPlayer->is_host &&
                                    $player->id !== $currentPlayer->id)
                                <button type="button" wire:click="kickPlayer({{ $player->id }})"
                                    class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white font-medium px-3 py-1 text-xs rounded-lg shadow-sm transition-all">
                                    KOV
                                </button>
                            @elseif ($this->canBeVoted($player))
                                <button type="button" wire:click="votePlayer({{ $player->id }})"
                                    class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-medium px-3 py-1 text-xs rounded-lg shadow-sm transition-all">
                                    @if ($this->hasVoted($player))
                                        İPTAL
                                    @else
                                        OY VER
                                    @endif
                                </button>
                            @elseif ($this->canUseAbility($player))
                                <button type="button" wire:click="selectTarget({{ $player->id }})"
                                    class="bg-gradient-to-r from-purple-600 to-purple-500 hover:from-purple-700 hover:to-purple-600 text-white font-medium px-3 py-1 text-xs rounded-lg shadow-sm transition-all">
                                    @if ($this->hasUsedAbility($player))
                                        İPTAL
                                    @else
                                        {{ $this->getAbilityName() }}
                                    @endif
                                </button>
                            @endif
                        </li>
                    @empty
                        <li class="text-center py-8 px-4 bg-gray-50 rounded-lg border border-gray-200">
                            <span class="text-4xl">☠️</span>
                            <p class="text-gray-600 mt-2">Yaşayan oyuncu yok.</p>
                        </li>
                    @endforelse
                </ul>
                @if ($currentPlayer->is_host && $lobby->state === App\Enums\ZalimKasaba\GameState::LOBBY)
                    <button wire:click="startGame" type="button"
                        class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white rounded px-3 py-2 font-bold text-lg mt-4 shadow-sm transition-all flex items-center justify-center gap-2">
                        <x-icons.arrow-right-alt size="20" />
                        Oyunu Başlat
                    </button>
                @endif
            </div>
        </div>
    </div>
    @if (
        $lobby->state !== App\Enums\ZalimKasaba\GameState::LOBBY &&
            $lobby->state !== App\Enums\ZalimKasaba\GameState::PREPARATION)
        <livewire:zalim-kasaba.last-will-modal :$lobby />
        <livewire:zalim-kasaba.show-last-will :$lobby />
    @endif
</div>
