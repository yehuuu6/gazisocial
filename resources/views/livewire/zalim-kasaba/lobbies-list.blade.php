<div class="bg-white p-8 rounded">
    <div class="flex items-center justify-between gap-3 mb-4">
        <h1 class="text-2xl font-bold text-gray-700">
            Aktif Oyunlar
        </h1>
        <a href="{{ route('games.zk.create') }}"
            class="bg-primary hover:bg-blue-950 font-medium text-white px-4 py-2 rounded">
            Yeni Oyun
        </a>
    </div>
    <div class="flex flex-col gap-4">
        @forelse ($lobbies as $lobby)
            <a href="{{ route('games.zk.show', $lobby->uuid) }}" wire:key="{{ $lobby->id }}"
                class="bg-gray-100 hover:bg-gray-200 rounded-lg p-4 flex items-center justify-between">
                <div>
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-lg font-bold text-gray-800 capitalize">{{ $lobby->name }}</h2>
                    </div>
                    <p class="text-sm text-gray-600">
                        {{ $lobby->host->name }} tarafından oluşturuldu.
                    </p>
                </div>
            </a>
        @empty
            <p class="text-gray-600">Henüz bir lobi oluşturulmamış.</p>
        @endforelse
    </div>
    <a href="{{ route('games.zk.guide') }}" class="text-center text-blue-400 hover:underline mt-5 text-sm w-full block">
        Rehbere dön
    </a>
</div>
