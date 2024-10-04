<div x-cloak x-show="open" @click.away="open = false" x-transition.duration.250ms
    x-anchor.bottom-start="$refs.searchToggle"
    class="flex flex-col gap-0.5 mt-1 z-10 shadow-md border border-gray-200 w-[350px] md:w-[375px] lg:w-[400px] bg-white rounded-lg overflow-hidden">

    <form wire:submit="goToSearchRoute" x-trap="open"
        class="flex m-2 items-center overflow-hidden border shadow rounded-md border-gray-300">
        <input wire:model.live="search" type="text" spellcheck="false" required
            class="px-4 py-2 text-sm flex-grow text-gray-700 focus:outline-none focus:border-blue-400"
            placeholder="{{ $placeholder }}" />
        <button type="submit" class="p-2 bg-primary text-sm text-white hover:bg-opacity-90">
            Ara
        </button>
    </form>

    <div class="max-h-[200px] md:max-h-[225px] lg:max-h-[250px] overflow-y-auto">
        @forelse ($results as $result)
            <div wire:key="{{ $result->id }}">
                @if ($this->isUserRoute($result))
                    <x-users.search-item :user="$result" />
                @else
                    <x-posts.search-item :post="$result" />
                @endif
            </div>
        @empty
            @if ($search)
                <div>
                    <span class="block p-2 hover:bg-gray-100 transition-all duration-200">Sonuç
                        bulunamadı.</span>
                </div>
            @endif
        @endforelse
    </div>
</div>
