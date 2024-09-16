<header
    class="mx-[3%] md:mx-[6%] lg:mx-[12%] flex flex-col gap-3 md:gap-0 md:flex-row md:justify-between md:items-center mt-4 md:mt-8">
    <div class="flex justify-between md:justify-start items-center gap-0.5">
        <div class="relative" x-data="{ open: false }">
            <button title="Kategoriler" @click="open = !open"
                class="py-2 flex items-center gap-2 px-3 text-gray-700 text-sm border font-medium border-gray-200 shadow bg-white rounded-md">
                Kategoriler
                <template x-if="open">
                    <x-icons.chevron-up size="12" color="black" />
                </template>
                <template x-if="!open">
                    <x-icons.chevron-down size="12" color="black" />
                </template>
            </button>
            <livewire:components.categories lazy />
        </div>
        <div class="flex items-center gap 1">
            <x-link href="/posts/latest"
                class="py-2 px-3 ml-3 text-gray-700 text-sm font-medium text-opacity-80 rounded-t-md hover:text-opacity-100 hover:no-underline">
                En Yeni
            </x-link>
            <x-link href="/posts/popular"
                class="py-2 px-3 text-gray-700 text-sm font-medium text-opacity-80 rounded-t-md hover:text-opacity-100 hover:no-underline">
                Popüler
            </x-link>
            <div class="relative md:hidden flex items-center justify-center" x-data="{ open: false }">
                <button title="Konu Ara" @click="open = !open"
                    class="p-2 text-opacity-90 rounded-full hover:bg-white hover:no-underline">
                    <x-icons.search size="20" color="rgb(11,62,117)" />
                </button>
                <livewire:components.search-bar lazy />
            </div>
        </div>
    </div>
    <div class="hidden md:flex items-center gap-2">
        <x-link href="/posts/create"
            class="py-2 px-3 text-white bg-primary text-sm font-medium text-opacity-90 rounded hover:text-opacity-100 hover:no-underline">
            Yeni Konu Oluştur
        </x-link>
        <x-link href="/faculties"
            class="py-2 px-3 text-primary border border-primary text-sm font-medium text-opacity-90 rounded hover:text-opacity-100 hover:no-underline">
            Fakülteye Katıl
        </x-link>
        <div class="relative flex items-center justify-center" x-data="{ open: false }">
            <button title="Konu Ara" @click="open = !open"
                class="p-2 text-opacity-90 rounded-full hover:bg-white hover:no-underline">
                <x-icons.search size="20" color="rgb(11,62,117)" />
            </button>
            <livewire:components.search-bar lazy />
        </div>
    </div>
</header>
