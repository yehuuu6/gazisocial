<div class="mx-[3%] mt-4 md:mx-[6%] md:mt-8 lg:mx-[12%]">
    <header class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between md:gap-0">
        <div class="flex items-center justify-between gap-3 md:justify-start">
            <div class="flex flex-row-reverse items-center gap-2 md:gap-3">
                <div class="relative" x-data="{ tagsDropdown: false }">
                    <x-ui.tooltip text="Konu Etiketlerini Aç" delay="1000">
                        <button x-on:click="tagsDropdown = !tagsDropdown"
                            class="flex items-center gap-2 rounded-md bg-white border border-gray-200 px-3 py-2 text-sm font-medium capitalize shadow">
                            <span>Etiketler</span>
                            <x-icons.arrow-down size="20" />
                        </button>
                    </x-ui.tooltip>
                </div>
            </div>
        </div>
        <div class="hidden items-center gap-2 md:flex">
            <x-link href="{{ route('posts.create') }}"
                class="rounded bg-primary border border-primary px-3 py-2 text-sm font-medium text-white bg-opacity-90 hover:bg-opacity-100 hover:no-underline">
                Yeni Konu Oluştur
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
</div>
