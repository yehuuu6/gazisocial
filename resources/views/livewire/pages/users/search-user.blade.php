<div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden">

    <x-header-title>
        "{{ $query }}" için Arama Sonuçları
    </x-header-title>

    <x-seperator />
    <x-scrollable-wrapper class="h-full" id="user-index">
        <ul wire:loading class="divide-y flex flex-1 flex-col gap-1 pb-5 w-full">
            @for ($i = 0; $i < 10; $i++)
                <x-posts.placeholder />
            @endfor
        </ul>
        <ul wire:loading.remove class="divide-y flex flex-1 flex-col gap-1 pb-5">
            @forelse ($users as $user)
                <livewire:components.user.user-item :$user :key="$user->id" />
            @empty
                <li class="p-5 text-center text-gray-500">
                    Arama sonucu bulunamadı.
                </li>
            @endforelse
        </ul>
    </x-scrollable-wrapper>
    {{ $users->links('livewire.pagination.simple') }}
</div>
@script
    <script>
        $wire.on('scroll-to-top', function() {
            const postIndexer = document.getElementById('user-index');
            postIndexer.scroll({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
@endscript
