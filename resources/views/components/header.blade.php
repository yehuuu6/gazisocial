@php
    $class = 'text-gray-700 bg-white';
    $text = 'Etiketler';

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
    class="mx-[3%] mt-4 flex flex-col gap-3 md:mx-[6%] md:mt-8 md:flex-row md:items-center md:justify-between md:gap-0 lg:mx-[12%]">
    <div class="flex items-center justify-between gap-3 md:justify-start">
        <div class="flex flex-row-reverse items-center gap-2 md:gap-3">
            <div class="relative" x-data="{ open: false }">
                <button x-ref="tagsToggle" title="Etiketler" @click="open = !open"
                    class="{{ $class }} flex items-center gap-2 rounded-md border border-gray-200 px-3 py-2 text-sm font-medium capitalize shadow">
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
        </div>
        <div class="flex items-center gap-1">
            <livewire:components.order-buttons />
            <div class="relative flex items-center justify-center md:hidden" x-data="{ open: false }">
                <button title="Arama Yap" @click="open = !open" x-ref="searchToggle"
                    class="rounded-full p-2 text-opacity-90 hover:bg-white hover:no-underline">
                    <x-icons.search size="20" color="rgb(11,62,117)" />
                </button>
                <livewire:components.search-bar />
            </div>
        </div>
    </div>
    <div class="hidden items-center gap-2 md:flex">
        <x-link href="{{ route('posts.create') }}"
            class="rounded bg-primary px-3 py-2 text-sm font-medium text-white text-opacity-90 hover:text-opacity-100 hover:no-underline">
            Yeni Konu Oluştur
        </x-link>
        @auth
            @if (!Auth::user()->faculty)
                <x-link href="/faculties"
                    class="rounded border border-primary px-3 py-2 text-sm font-medium text-primary text-opacity-90 hover:text-opacity-100 hover:no-underline">
                    Fakülteye Katıl
                </x-link>
            @endif
        @endauth
        <div class="relative flex items-center justify-center" x-data="{ open: false }">
            <button title="Arama Yap" @click="open = !open" x-ref="searchToggle"
                class="rounded-full p-2 hover:bg-white">
                <x-icons.search size="20" color="rgb(11,62,117)" />
            </button>
            <livewire:components.search-bar />
        </div>
    </div>
</header>
