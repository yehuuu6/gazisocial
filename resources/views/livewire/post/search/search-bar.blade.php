<div class="bg-white shadow-md rounded-md py-2 px-2.5 w-[500px]">
    <div class="flex items-center gap-0.5 justify-between">
        <input spellcheck="false" type="text" wire:model.live.debounce.250ms="search"
            class="bg-gray-50 px-3 rounded-md py-3 text-gray-700 w-full h-full outline-none" placeholder="Konu ara" />
        <button type="button" class="rounded p-2 opacity-70 hover:opacity-100">
            <x-ui.tooltip text="Gelişmiş Arama" delay="500">
                <x-icons.advanced size="24" class="text-primary" />
            </x-ui.tooltip>
        </button>
    </div>
    <div class="flex flex-col overflow-y-auto max-h-[300px]">
        @if ($posts->isNotEmpty())
            <div class="mt-2"></div>
        @endif
        @forelse ($posts as $post)
            <x-link href="{{ $post->showRoute() }}"
                class="bg-white hover:bg-gray-50 py-3 px-5 rounded flex flex-col gap-2 hover:no-underline"
                wire:key='{{ $post->id }}'>
                <h2 class="text-lg font-medium text-gray-700">{{ $post->title }}</h2>
                <p class="text-sm text-gray-500 font-normal">
                    {{ mb_substr(strip_tags($post->html), 0, 150, 'UTF-8') }}...
                </p>
            </x-link>
        @empty
            @if (strlen($search) > 3)
                <div class="flex items-center mt-2 gap-3 bg-white py-3 px-5 rounded text-gray-500 text-base">
                    <x-icons.sad size="20" />
                    <span>Sonuç bulunamadı.</span>
                </div>
            @endif
        @endforelse
    </div>
    @if ($posts->isNotEmpty())
        <div class="mt-4 flex items-end justify-end">
            <a target="_blank" href="https://www.algolia.com/developers">
                <img src="{{ asset('logos/Algolia-logo-blue.png') }}" alt="Search by Algolia" class="w-20" />
            </a>
        </div>
    @endif
</div>
