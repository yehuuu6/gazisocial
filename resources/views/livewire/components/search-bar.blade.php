<div x-cloak x-show="open" @click.away="open = false" x-transition.duration.250ms
    x-anchor.bottom-start="$refs.searchToggle"
    class="z-10 mt-1 flex w-[350px] flex-col gap-0.5 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-md md:w-[375px] lg:w-[400px]">

    <form wire:submit="goToSearchRoute" x-trap="open"
        class="m-2 flex items-center overflow-hidden rounded-md border border-gray-300 shadow">
        <input wire:model.live="search" type="text" spellcheck="false" required id="search" name="search"
            class="flex-grow px-4 py-2 text-sm text-gray-700 focus:border-blue-400 focus:outline-none"
            placeholder="{{ $placeholder }}" />
        <button type="submit" class="bg-primary p-2 text-sm text-white hover:bg-opacity-90">
            Ara
        </button>
    </form>

    <div class="max-h-[200px] overflow-y-auto md:max-h-[225px] lg:max-h-[250px]">
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
                    <span class="block p-2 transition-all duration-200 hover:bg-gray-100">Sonuç
                        bulunamadı.</span>
                </div>
            @endif
        @endforelse
    </div>
</div>
