<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8 max-w-5xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-3">Yeni Oyun Oluştur</h1>
        <p class="text-gray-600 font-medium">Oynamak istediğiniz rolleri seçerek kendi özel Zalim Kasaba oyununuzu
            oluşturun.</p>
    </div>

    <form wire:submit="createLobby" class="flex flex-col gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-4">
                <h2 class="text-white font-bold text-lg flex items-center gap-2">
                    <x-icons.edit size="20" />
                    Oyun Bilgileri
                </h2>
            </div>
            <div class="p-5">
                <div class="flex flex-col gap-3">
                    <label for="lobbyName" class="text-gray-700 font-medium">Oda Adı</label>
                    <input type="text" wire:model="lobbyName" id="lobbyName"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
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
        }" class="flex gap-6 w-full flex-col">
            <!-- Rol Seçim Alanı -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-500 p-4">
                    <h2 class="text-white font-bold text-lg flex items-center gap-2">
                        <x-icons.user size="20" />
                        Roller
                        <span class="text-sm font-normal text-white/80">
                            (Özel roller sadece bir defa seçilebilir)
                        </span>
                    </h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                        <!-- Tüm Roller -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">Mevcut Roller</h3>
                            <div class="h-72 overflow-y-auto bg-gray-50 rounded-lg border border-gray-200 p-3">
                                @forelse ($gameRoles as $role)
                                    <button type="button" x-on:click="selectRole({{ $role }})"
                                        wire:key="{{ $role->id }}"
                                        class="bg-white mb-2 flex items-center gap-2 w-full hover:bg-gray-50 text-gray-800 px-4 py-3 rounded-lg border border-gray-100 shadow-sm transition-all">
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
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">
                                Seçilen Roller
                                <span class="text-sm font-normal text-gray-500"
                                    x-text="'(' + selectedRoles.length + ' rol)'"></span>
                            </h3>
                            <div class="h-72 overflow-y-auto bg-gray-50 rounded-lg border border-gray-200 p-3">
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
                                            <x-icons.close size="18" />
                                        </span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-4">
                <button type="submit"
                    class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white px-6 py-3 rounded font-medium shadow-sm transition-all flex items-center gap-2">
                    <x-icons.check size="20" />
                    Lobiyi Kur
                </button>
            </div>
        </div>
    </form>
</div>
