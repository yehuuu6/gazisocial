@php
    $class = 'text-gray-700 bg-white';
    $text = 'Kategoriler';

    if (Request::is('tags/*')) {
        $slug = explode('/', Request::path())[1];
        $text = optional(\App\Models\Tag::where('slug', $slug)->first())->name ?? $text;
        $class = 'text-primary bg-blue-100';
    } elseif (Request::is('posts/search/*')) {
        $slug = explode('/', Request::path())[2];

        if ($slug !== 'all') {
            $text = optional(\App\Models\Tag::where('slug', $slug)->first())->name ?? $text;
            $class = 'text-primary bg-blue-100';
        }
    }
@endphp
<header
    class="mx-[3%] md:mx-[6%] lg:mx-[12%] flex flex-col gap-3 md:gap-0 md:flex-row md:justify-between md:items-center mt-4 md:mt-8">
    <div class="flex justify-between md:justify-start items-center gap-0.5">
        <div class="relative" x-data="{ open: false }">
            <button title="Kategoriler" @click="open = !open"
                class="py-2 capitalize flex items-center gap-2 px-3 {{ $class }} text-sm border font-medium border-gray-200 shadow rounded-md">
                {{ $text }}
                <template x-if="open">
                    <x-icons.chevron-up size="12" color="black" />
                </template>
                <template x-if="!open">
                    <x-icons.chevron-down size="12" color="black" />
                </template>
            </button>
            <livewire:components.tags-lister />
        </div>
        <div class="flex items-center gap-1">
            <x-link href="{{ route('posts.index', 'latest') }}"
                class="py-2 px-3 ml-3 text-sm font-medium rounded-md hover:no-underline {{ Request::is('posts/latest') || Request::is('/') ? 'bg-blue-100 text-primary' : 'text-gray-700 text-opacity-80 hover:text-opacity-100' }}">
                En Yeni
            </x-link>
            <x-link href="{{ route('posts.index', 'popular') }}"
                class="py-2 px-3 text-sm font-medium rounded-md hover:no-underline {{ Request::is('posts/popular') ? 'bg-blue-100 text-primary' : 'text-gray-700 text-opacity-80 hover:text-opacity-100' }}">
                Popüler
            </x-link>
            <div class="relative md:hidden flex items-center justify-center" x-data="{ open: false }">
                <button title="Arama Yap" @click="open = !open"
                    class="p-2 text-opacity-90 rounded-full hover:bg-white hover:no-underline">
                    <x-icons.search size="20" color="rgb(11,62,117)" />
                </button>
                <livewire:components.search-bar />
            </div>
        </div>
    </div>
    <div class="hidden md:flex items-center gap-2">
        <x-link href="{{ route('posts.create') }}"
            class="py-2 px-3 text-white bg-primary text-sm font-medium text-opacity-90 rounded hover:text-opacity-100 hover:no-underline">
            Yeni Konu Oluştur
        </x-link>
        <x-link href="/faculties"
            class="py-2 px-3 text-primary border border-primary text-sm font-medium text-opacity-90 rounded hover:text-opacity-100 hover:no-underline">
            Fakülteye Katıl
        </x-link>
        <div class="relative flex items-center justify-center" x-data="{ open: false }">
            <button title="Arama Yap" @click="open = !open"
                class="p-2 text-opacity-90 rounded-full hover:bg-white hover:no-underline">
                <x-icons.search size="20" color="rgb(11,62,117)" />
            </button>
            <livewire:components.search-bar />
        </div>
    </div>
</header>
