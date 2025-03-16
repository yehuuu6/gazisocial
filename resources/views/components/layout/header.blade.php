<div x-data="{
    isHome: '{{ request()->routeIs('home') }}',
    isTagsShowLatest: '{{ request()->routeIs('tags.show') && (request('order') === 'latest' || request('order') === null) }}',
    isTagsShowPopular: '{{ request()->routeIs('tags.show') && request('order') === 'popular' }}',
    isPostsIndexLatest: '{{ request()->routeIs('posts.index') && (request('order') === 'latest' || request('order') === null) }}',
    isPostsIndexPopular: '{{ request()->routeIs('posts.index') && request('order') === 'popular' }}',
}" class="mx-[3%] mt-4 xl:mx-[6%] md:mt-8 2xl:mx-[12%]">
    <header class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between md:gap-0">
        <div class="flex justify-between gap-1 md:justify-start">
            @persist('tags-lister')
                <livewire:tag.tags-lister />
            @endpersist
            <div class="flex gap-1 items-center justify-end flex-wrap ml-2.5">
                <a :class="{
                    'text-primary bg-blue-300 bg-opacity-30': isHome,
                    'text-gray-700 bg-gray-200 bg-opacity-0 hover:bg-opacity-65': !isHome
                }"
                    wire:navigate.hover href="{{ route('home') }}"
                    class="hidden md:block rounded px-3 md:px-4 py-2 font-medium text-sm hover:no-underline">
                    Ana Sayfa
                </a>
                <a :class="{
                    'text-primary bg-blue-300 bg-opacity-30': isTagsShowLatest || isPostsIndexLatest,
                    'text-gray-700 bg-gray-200 bg-opacity-0 hover:bg-opacity-65': !isTagsShowLatest && !
                        isPostsIndexLatest
                }"
                    wire:navigate.hover
                    href="{{ request()->routeIs('tags.show') ? route('tags.show', ['tag' => request('tag'), 'order' => 'latest']) : route('posts.index', 'latest') }}"
                    class="rounded px-3 md:px-4 py-2 font-medium text-sm hover:no-underline">
                    En Yeni
                </a>
                <a :class="{
                    'text-primary bg-blue-300 bg-opacity-30': isTagsShowPopular || isPostsIndexPopular,
                    'text-gray-700 bg-gray-200 bg-opacity-0 hover:bg-opacity-65': !isTagsShowPopular && !
                        isPostsIndexPopular
                }"
                    wire:navigate.hover
                    href="{{ request()->routeIs('tags.show') ? route('tags.show', ['tag' => request('tag'), 'order' => 'popular']) : route('posts.index', 'popular') }}"
                    class="rounded px-3 md:px-4 py-2 font-medium text-sm hover:no-underline">
                    Popüler
                </a>
            </div>
        </div>
        <div class="hidden items-center gap-2 md:flex">
            <x-link href="{{ route('posts.create') }}"
                class="rounded bg-primary border border-primary px-3 py-2 text-sm font-medium text-white bg-opacity-90 hover:bg-opacity-100 hover:no-underline">
                Yeni Konu
            </x-link>
            @can('join', App\Models\Faculty::class)
                @if (!Auth::user()->faculty)
                    <x-link href="{{ route('faculties') }}"
                        class="rounded border border-primary px-3 py-2 text-sm font-medium text-primary text-opacity-90 hover:text-opacity-100 hover:no-underline">
                        Fakülteye Katıl
                    </x-link>
                @endif
            @endcan
        </div>
    </header>
    @if (request()->is('posts/popular') || request()->is('tags/*/popular'))
        <x-layout.post-time-selector />
    @endif
</div>
