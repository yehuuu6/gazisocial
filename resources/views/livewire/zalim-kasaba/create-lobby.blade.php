<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8 max-w-5xl mx-auto">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-3">Yeni Oyun Oluştur</h1>
        <p class="text-gray-600 font-medium">Oynamak istediğiniz rolleri seçerek kendi özel Zalim Kasaba oyununuzu
            oluşturun.</p>
    </div>

    <div class="mt-5 mb-7 w-fit space-y-3">
        <x-alerts.warning>
            Oyun yöneticisi olarak oyun oynanırken çevrimiçi kalmalısınız. Oyundan anlık olarak bile ayrılırsanız,
            oyununuzun
            işleyişi zarar görebilir.
        </x-alerts.warning>
        <x-alerts.warning>
            Oyun yöneticisi olarak oyundan ayrıldığınızda, diğer oyuncular oyuna devam edemez. Ve lobi belli bir süre
            sonra silinir.
        </x-alerts.warning>
    </div>

    <form wire:submit="createLobby" class="flex flex-col gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-4">
                <h2 class="text-white font-bold text-lg flex items-center gap-2">
                    <x-tabler-edit class="size-5" />
                    Oyun Bilgileri
                </h2>
            </div>
            <div class="p-5">
                <div class="flex flex-col gap-3">
                    <label for="lobbyName" class="text-gray-700 font-medium">Oda Adı</label>
                    <input type="text" autocomplete="off" spellcheck="false" wire:model="lobbyName" id="lobbyName"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">

                    <div class="flex items-center justify-between">
                        <label for="rolesHidden" class="text-gray-700 font-medium">Rolleri Gizle</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="rolesHidden" id="rolesHidden" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </div>
                    <p class="text-sm text-gray-500">
                        Rolleri gizlemek, rol listesinde bulunan rol isimlerinin gizli kalmasını sağlar. Sadece taraflar
                        belli olur. Özel rollerin isimleri gizlenmez. Sadece oyun kurucusu rolleri görebilir.
                    </p>
                </div>
            </div>
        </div>

        <div x-data="{
            selectedRoles: $wire.entangle('selectedRoles'),
            selectRole(role) {
                role.uuid = Math.random().toString(36).substring(7);
                this.selectedRoles.push(role);
            },
            removeRole(uuid) {
                this.selectedRoles = this.selectedRoles.filter(role => role.uuid !== uuid);
            },
        }" class="flex gap-6 w-full flex-col"
            x-effect="$wire.set('selectedRoles', selectedRoles)">
            <!-- Rol Seçim Alanı -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-500 p-4">
                    <h2 class="text-white font-bold text-lg flex items-center gap-2">
                        <x-tabler-users class="size-5" />
                        Roller
                        <span class="text-sm font-normal text-white/80">
                            (Özel roller sadece bir defa seçilebilir)
                        </span>
                    </h2>
                </div>
                <div class="flex items-center gap-2 flex-wrap px-5 mt-5">
                    <h3 class="w-full text-gray-700 font-medium mb-2">Hazır Oyun Setleri:</h3>
                    <button type="button" wire:click="loadPreset('beginner')"
                        class="border border-green-500 hover:bg-green-50 transition-all duration-300 hover:text-green-600 hover:border-green-600 text-green-500 bg-white rounded px-3 py-1.5 text-sm font-medium">
                        Başlangıç (7 Oyuncu)
                    </button>
                    <button type="button" wire:click="loadPreset('classic')"
                        class="border border-blue-500 hover:bg-blue-50 transition-all duration-300 hover:text-blue-600 hover:border-blue-600 text-blue-500 bg-white rounded px-3 py-1.5 text-sm font-medium">
                        Klasik (10 Oyuncu)
                    </button>
                    <button type="button" wire:click="loadPreset('balanced')"
                        class="border border-purple-500 hover:bg-purple-50 transition-all duration-300 hover:text-purple-600 hover:border-purple-600 text-purple-500 bg-white rounded px-3 py-1.5 text-sm font-medium">
                        Dengeli (12 Oyuncu)
                    </button>
                    <button type="button" wire:click="loadPreset('chaos')"
                        class="border border-red-500 hover:bg-red-50 transition-all duration-300 hover:text-red-600 hover:border-red-600 text-red-500 bg-white rounded px-3 py-1.5 text-sm font-medium">
                        Kaos (15 Oyuncu)
                    </button>
                </div>
                <div class="px-5 mt-5 mb-1 w-fit">
                    <x-alerts.warning>
                        Seçilen rol sayısına göre oyuncu sayısı belirlenecektir. Kaç kişi oynayacaksa ona göre
                        rol listesi yapılmalıdır.
                    </x-alerts.warning>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                        <!-- Tüm Roller -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">Mevcut Roller</h3>
                            <div class="h-72 lg:h-96 overflow-y-auto bg-gray-50 rounded-lg border border-gray-200 p-3">
                                @forelse ($gameRoles as $role)
                                    <button type="button" x-on:click="selectRole({{ $role }})"
                                        wire:key="{{ $role->id }}"
                                        class="bg-white mb-2 flex items-center gap-2 w-full hover:bg-green-50 text-gray-800 px-4 py-3 rounded-lg border border-gray-100 shadow-sm transition-all">
                                        <span class="text-xl">{{ $role->icon }}</span>
                                        <div class="flex flex-col items-start">
                                            <span class="font-medium">{{ $role->name }}</span>
                                            <span class="text-xs font-medium"
                                                :class="{
                                                    'text-red-600': '{{ $role->enum->getFaction() }}' == 'Mafya 🌹',
                                                    'text-green-600': '{{ $role->enum->getFaction() }}' == 'Kasaba 🏘️',
                                                    'text-purple-500': '{{ $role->enum->getFaction() }}' == 'Kaos 🌀',
                                                    'text-yellow-500': '{{ $role->enum->getFaction() }}' ==
                                                        'Tarafsız 🕊️'
                                                }">
                                                {{ $role->enum->getFaction() }}
                                                @if ($this->isUnique($role->enum))
                                                    <span class="text-orange-600 ml-1">(Özel Rol)</span>
                                                @endif
                                            </span>
                                        </div>
                                    </button>
                                @empty
                                    <div class="text-center py-8 text-gray-500">Hiçbir rol bulunamadı.</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Seçilen Roller -->
                        <div>
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-lg font-semibold text-gray-700 mb-3">
                                    Seçilen Roller
                                    <span class="text-sm font-normal text-gray-500"
                                        x-text="'(' + selectedRoles.length + ' oyuncu)'"></span>
                                </h3>
                                <button type="button" x-on:click="selectedRoles = []" x-cloak
                                    x-show="selectedRoles.length > 0"
                                    class="text-red-500 hover:text-red-700 font-medium">
                                    Temizle
                                </button>
                            </div>
                            <div class="h-72 lg:h-96 overflow-y-auto bg-gray-50 rounded-lg border border-gray-200 p-3">
                                <template x-if="selectedRoles.length === 0">
                                    <div class="text-center py-8 text-gray-500">Henüz rol seçilmedi</div>
                                </template>
                                <template x-for="role in selectedRoles" :key="role.uuid">
                                    <button type="button" x-on:click="removeRole(role.uuid)"
                                        class="bg-white mb-2 flex items-center justify-between w-full hover:bg-red-50 text-gray-800 px-4 py-3 rounded-lg border border-gray-100 shadow-sm transition-all">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xl" x-text="role.icon"></span>
                                            <span class="font-medium" x-text="role.name"></span>
                                        </div>
                                        <span class="text-red-500 hover:text-red-700">
                                            <x-tabler-x class="size-5" />
                                        </span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-6 justify-between mt-4 flex-col-reverse md:flex-row">
                <a href="{{ route('games.zk.guide') }}"
                    class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                    <x-tabler-arrow-left class="size-5" />
                    Rehbere Dön
                </a>
                <div class="flex items-center lg:justify-end gap-4">
                    <a href="{{ route('games.zk.lobbies') }}"
                        class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-6 py-3 rounded font-medium shadow-sm transition-all flex items-center gap-2">
                        <x-tabler-arrow-right class="size-5" />
                        Lobileri Gör
                    </a>
                    <button type="submit"
                        class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white px-6 py-3 rounded font-medium shadow-sm transition-all flex items-center gap-2">
                        <x-tabler-check class="size-5" />
                        Lobiyi Kur
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
