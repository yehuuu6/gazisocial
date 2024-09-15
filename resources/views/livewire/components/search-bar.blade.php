<form wire:submit="goToSearchRoute" class="flex w-2/3 md:w-1/3 relative m-2.5 mr-0 sm:m-0" enctype="multipart/form-data">
    <input type="text" autocomplete="off"
        class="p-2 w-full text-black rounded rounded-tr-none rounded-br-none border border-gray-300 outline-none"
        placeholder='{{ $placeholder }}' wire:model.live="search" required>
    <button type="submit" class="p-2 bg-blue-500 grid place-items-center rounded rounded-tl-none rounded-bl-none">
        <x-icons.search color='white' size='24' />
    </button>

    <ul class="absolute w-full divide-y bg-white rounded-b-lg shadow-lg z-10 top-[2.65rem]">
        @forelse ($results as $result)
            <li wire:key="{{ $result->id }}">
                @if ($currentRoute === 'user.show' || $currentRoute === 'user.search' || $currentRoute === 'user.edit')
                    <x-users.search-item :user="$result" />
                @else
                    <x-posts.search-item :post="$result" />
                @endif
            </li>
        @empty
            @if ($search)
                <li>
                    <span class="block p-2 hover:bg-gray-100 transition-all duration-200">Sonuç
                        bulunamadı.</span>
                </li>
            @endif
        @endforelse
    </ul>
</form>
