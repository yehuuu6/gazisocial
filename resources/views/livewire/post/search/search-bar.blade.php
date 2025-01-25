<div x-data="{ searchOpen: false }">
    <button x-on:click="searchOpen = !searchOpen" x-ref="searchButton" type="button"
        class="rounded-md p-3 hover:bg-gray-100">
        <x-icons.search size="25" class="text-primary" />
    </button>
    <div x-cloak x-show="searchOpen" x-transition.origin.top.center x-anchor.offset.5.bottom-center="$refs.searchButton"
        class="z-10">
        <div class="bg-white shadow-md rounded-md py-2 px-2.5 w-[350px] md:w-[500px]"
            x-on:click.away="searchOpen = false">
            <div class="flex items-center gap-0.5 justify-between">
                <input spellcheck="false" type="text" wire:model.live.debounce.250ms="search"
                    class="bg-gray-50 text-sm md:text-base px-3 rounded-md py-3 text-gray-700 w-full h-full outline-none"
                    placeholder="🔎 Konu ara" />
                <button type="button" class="rounded p-2 pr-0 opacity-70 hover:opacity-100"
                    x-on:click="alert('Not implemented yet!')">
                    <x-ui.tooltip text="Gelişmiş Arama" delay="500">
                        <x-icons.advanced size="24" class="text-primary" />
                    </x-ui.tooltip>
                </button>
            </div>
            <div class="flex flex-col overflow-y-auto max-h-[300px]">
                @if ($posts->isNotEmpty() && strlen($search) > 2)
                    <div class="mt-2"></div>
                @endif
                @forelse ($posts as $post)
                    <button type="button" wire:key='{{ $post->id }}' wire:click="resetSearch"
                        x-on:click="searchOpen = false; Livewire.navigate('{{ $post->showRoute() }}');"
                        class="bg-white hover:bg-gray-50 py-2 px-3.5 md:py-3 md:px-5 rounded text-left flex flex-col gap-2 hover:no-underline">
                        <h2 class="text-base md:text-lg font-medium text-gray-700 break-words">{{ $post->title }}</h2>
                        <p class="text-xs md:text-sm text-gray-500 font-normal break-words">
                            {{ mb_substr(strip_tags($post->html), 0, 150, 'UTF-8') }}...
                        </p>
                    </button>
                @empty
                    @if (strlen($search) > 2)
                        <div
                            class="flex items-center mt-2 gap-3 bg-white py-2 px-3.5 md:py-3 md:px-5 rounded text-gray-500 text-sm md:text-base">
                            <x-icons.sad size="20" />
                            <span>Sonuç bulunamadı.</span>
                        </div>
                    @endif
                @endforelse
            </div>
            @if ($posts->isNotEmpty())
                <div class="mt-4 mr-1 flex items-end justify-end">
                    <a target="_blank" href="https://www.algolia.com/developers">
                        <img src="{{ asset('logos/Algolia-logo-blue.png') }}" alt="Search by Algolia"
                            class="w-16 md:w-20" />
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
