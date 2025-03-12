<div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
    <h1 class="text-2xl font-bold text-gray-700 mb-4">
        Yeni Oda Oluştur
    </h1>
    <form wire:submit="createLobby" class="flex flex-col gap-4">
        <div class="flex flex-col gap-2">
            <label for="lobbyName" class="text-gray-600">Oda Adı</label>
            <input type="text" wire:model="lobbyName" id="lobbyName"
                class="border border-gray-300 rounded-lg p-2 w-full">
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
        }" class="flex gap-4 w-full flex-col-reverse md:flex-row">
            <div class="w-full md:w-1/2">
                <h1 class="text-xl font-bold text-gray-700">
                    Seçilen Roller
                </h1>
                <div class="flex h-96 overflow-y-auto flex-col gap-2 bg-gray-100 rounded p-4">
                    <template x-for="role in selectedRoles" :key="index">
                        <button type="button" x-on:click="removeRole(role.uuid)"
                            class="bg-white hover:bg-gray-50 font-medium w-full text-gray-800 px-4 py-2 rounded">
                            <span x-text="role.icon + ' ' + role.name"></span>
                        </button>
                    </template>
                </div>
            </div>
            <div class="w-1/2">
                <h1 class="text-xl font-bold text-gray-700 mb-1">
                    Roller <span class="text-gray-600 font-normal text-sm">
                        (Özel roller sadece bir defa seçilebilir.)
                    </span>
                </h1>
                <div class="flex h-96 overflow-y-auto flex-col gap-2 bg-gray-100 rounded p-4">
                    @forelse ($gameRoles as $role)
                        <button type="button" x-on:click="selectRole({{ $role }})"
                            wire:key="{{ $role->id }}"
                            class="bg-white flex items-center gap-1 font-medium w-full hover:bg-gray-50 text-gray-800 px-4 py-2 rounded">
                            {{ $role->icon }}
                            {{ $role->name }}
                            <span class="text-sm font-bold"
                                :class="{
                                    'text-red-600': '{{ $role->enum->getFaction() }}' ==
                                        'Mafya 🌹',
                                    'text-green-600': '{{ $role->enum->getFaction() }}' ==
                                        'Kasaba 🏘️',
                                    'text-purple-500': '{{ $role->enum->getFaction() }}' ==
                                        'Kaos 🌀',
                                    'text-yellow-500': '{{ $role->enum->getFaction() }}' ==
                                        'Tarafsız 🕊️'
                                }">
                                ({{ $role->enum->getFaction() }})
                            </span>
                            @if ($this->isUnique($role->enum))
                                <span class="text-sm font-bold text-orange-600">
                                    (Özel Rol)
                                </span>
                            @endif
                        </button>
                    @empty
                        <h1>
                            Hiçbir rol bulunamadı.
                        </h1>
                    @endforelse
                </div>
            </div>
        </div>
        <button type="submit"
            class="self-start bg-blue-500 font-medium hover:bg-blue-600 text-white px-4 py-2 mt-10 rounded">
            Oyunu Başlat
        </button>
    </form>
</div>
