<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
    <div class="max-w-5xl mx-auto">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-3">Aktif Oyunlar</h1>
            <p class="text-gray-600 font-medium">Mevcut oyunlara katılın veya kendi Zalim Kasaba oyununuzu oluşturun.</p>
        </div>

        <div class="my-4 w-fit">
            <x-alerts.warning>
                Lobiler her 5 dakikada bir aktiflik durumuna göre otomatik olarak temizlenir.
            </x-alerts.warning>
        </div>

        <div class="flex items-center justify-between gap-3 mb-6 flex-col md:flex-row">
            <a href="{{ route('games.zk.guide') }}"
                class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                <x-tabler-arrow-left class="size-5" />
                Rehbere Dön
            </a>
            <a href="{{ route('games.zk.create') }}"
                class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm transition-all flex items-center gap-2">
                <x-tabler-eye class="size-5" />
                Yeni Oyun Oluştur
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            @if ($this->myLobbies->isNotEmpty())
                <div class="bg-gradient-to-r from-green-500 to-lime-500 p-4">
                    <h2 class="text-white font-bold text-lg flex items-center gap-2">
                        <x-tabler-device-gamepad-2 class="size-5" />
                        Katıldığım Oyunlar
                    </h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($this->myLobbies as $lobby)
                            <a href="{{ route('games.zk.show', $lobby->uuid) }}" wire:key="{{ $lobby->id }}"
                                class="bg-white rounded-lg p-4 flex items-center justify-between border border-gray-200 shadow-sm hover:bg-gray-50 hover:border-purple-200 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="rounded-full size-12 flex items-center justify-center shadow-sm">
                                        <img src="{{ asset($lobby->host->getAvatar()) }}" alt="{{ $lobby->host->name }}"
                                            class="rounded-full size-12 object-cover">
                                    </div>
                                    <div>
                                        <div class="flex md:items-center md:gap-1 flex-col md:flex-row">
                                            <span style="word-break: break-word;"
                                                class="md:text-base lg:text-lg font-bold text-gray-800 capitalize">
                                                {{ $lobby->name }}
                                            </span>
                                            <span class="text-xs text-gray-500 font-medium">
                                                ({{ $lobby->players()->count() }} /
                                                {{ $lobby->max_players }})
                                            </span>
                                        </div>
                                        <span class="text-xs lg:text-sm text-gray-500 flex items-center gap-1 mt-1">
                                            {{ $lobby->host->username }} tarafından oluşturuldu
                                        </span>
                                    </div>
                                </div>
                                <span class="text-purple-600 hover:text-purple-800">
                                    <x-tabler-arrow-right class="size-5" />
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="bg-gradient-to-r from-purple-600 to-purple-500 p-4">
                <h2 class="text-white font-bold text-lg flex items-center gap-2">
                    <x-tabler-device-gamepad-2 class="size-5" />
                    Mevcut Lobiler
                </h2>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 gap-4">
                    @forelse ($lobbies as $lobby)
                        <a href="{{ route('games.zk.show', $lobby->uuid) }}" wire:key="{{ $lobby->id }}"
                            class="bg-white rounded-lg p-4 flex items-center justify-between border border-gray-200 shadow-sm hover:bg-gray-50 hover:border-purple-200 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="rounded-full size-12 flex items-center justify-center shadow-sm">
                                    <img src="{{ asset($lobby->host->getAvatar()) }}" alt="{{ $lobby->host->name }}"
                                        class="rounded-full size-12 object-cover">
                                </div>
                                <div>
                                    <div class="flex md:items-center md:gap-1 flex-col md:flex-row">
                                        <span style="word-break: break-word;"
                                            class="md:text-base lg:text-lg font-bold text-gray-800 capitalize">
                                            {{ $lobby->name }}
                                        </span>
                                        <span class="text-xs text-gray-500 font-medium">
                                            ({{ $lobby->players->count() }} / {{ $lobby->max_players }})
                                        </span>
                                    </div>
                                    <span class="text-xs lg:text-sm text-gray-500 flex items-center gap-1 mt-1">
                                        {{ $lobby->host->username }} tarafından oluşturuldu
                                    </span>
                                </div>
                            </div>
                            <span class="text-purple-600 hover:text-purple-800">
                                <x-tabler-arrow-right class="size-5" />
                            </span>
                        </a>
                    @empty
                        <div class="text-center py-10 px-4">
                            <div class="mb-4">
                                <span class="text-4xl">🎮</span>
                            </div>
                            <h3 class="text-lg font-medium text-gray-800 mb-2">Henüz bir lobi oluşturulmamış</h3>
                            <p class="text-gray-600">İlk oyunu oluşturarak arkadaşlarınla eğlenceye başla!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        {{ $lobbies->links('livewire.pagination.profile') }}
    </div>
</div>
