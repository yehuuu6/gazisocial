<div>
    <div x-ref="sortComments">
        <x-ui.tooltip text="Sıralama seçeneklerini aç" delay="1000">
            <button x-on:click="sortDropdown = !sortDropdown" wire:target="setSortMethod" wire:loading.attr="disabled"
                class="px-4 py-2 flex items-center gap-2 text-gray-600 font-medium text-xs rounded-full hover:bg-gray-100 active:bg-gray-300 focus:bg-gray-200"
                type="button">
                <span wire:loading.remove wire:target="setSortMethod" x-text="sortMap[selectedSort] + ' Yorumlar'">
                </span>
                <div wire:loading.flex wire:target="setSortMethod" class="flex items-center gap-2">
                    <x-icons.spinner size="18" class="text-gray-700" />
                    <span class="font-normal">Yükleniyor</span>
                </div>
                <x-tabler-chevron-down class="size-5" wire:loading.remove wire:target="setSortMethod" x-cloak
                    x-show="!sortDropdown" />
                <x-tabler-chevron-up class="size-5" wire:loading.remove wire:target="setSortMethod" x-cloak
                    x-show="sortDropdown" />
            </button>
        </x-ui.tooltip>
    </div>
    <div x-anchor.bottom-center.offset.5="$refs.sortComments" x-cloak x-show="sortDropdown"
        x-on:click.outside="sortDropdown = false" x-transition.scale.origin.top x-on:click="sortDropdown = false"
        class="bg-white shadow-lg text-xs md:text-sm text-gray-800 font-medium rounded-lg z-10 border-t border-gray-100 max-v-[50vh] overflow-y-auto w-[150px]">
        <button wire:click="setSortMethod('popularity')" type="button" x-on:click="selectedSort = 'popularity'"
            class="flex items-center gap-5 md:gap-3 px-3.5 py-2.5 size-full md:px-4 md:py-3 hover:bg-gray-100">
            <x-tabler-heart-f class="text-pink-400 size-6" />
            <span>
                Popüler
            </span>
        </button>
        <button wire:click="setSortMethod('newest')" type="button" x-on:click="selectedSort = 'newest'"
            class="flex items-center gap-5 md:gap-3 px-3.5 py-2.5 size-full md:px-4 md:py-3 hover:bg-gray-100">
            <x-tabler-flame-f class="text-yellow-400 size-6" />
            <span>
                Yeni
            </span>
        </button>
        <button wire:click="setSortMethod('oldest')" type="button" x-on:click="selectedSort = 'oldest'"
            class="flex items-center gap-5 md:gap-3 px-3.5 py-2.5 size-full md:px-4 md:py-3 hover:bg-gray-100">
            <x-tabler-hourglass-f class="text-blue-400 size-6" />
            <span>
                Eski
            </span>
        </button>
    </div>
</div>
