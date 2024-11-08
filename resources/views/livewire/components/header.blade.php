<div class="mx-[3%] mt-4 md:mx-[6%] md:mt-8 lg:mx-[12%]">
    <header class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between md:gap-0">
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
            <div class="flex items-center gap-1 flex-wrap justify-end md:justify-normal" x-data="{ open: false }">
                <livewire:components.order-buttons />
                @if (session()->has('order') && session('order') === 'popularity')
                    <livewire:components.popular-time />
                @endif
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
                @can('join', App\Models\Faculty::class)
                    @if (!Auth::user()->faculty)
                        <x-link href="{{ route('faculties') }}"
                            class="rounded border border-primary px-3 py-2 text-sm font-medium text-primary text-opacity-90 hover:text-opacity-100 hover:no-underline">
                            Fakülteye Katıl
                        </x-link>
                    @endif
                @endcan
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
</div>
