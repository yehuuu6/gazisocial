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
                <x-icons.arrow-down size="18" wire:loading.remove wire:target="setSortMethod" x-cloak
                    x-show="!sortDropdown" />
                <x-icons.arrow-up size="18" wire:loading.remove wire:target="setSortMethod" x-cloak
                    x-show="sortDropdown" />
            </button>
        </x-ui.tooltip>
    </div>
    <div x-anchor.bottom-center.offset.5="$refs.sortComments" x-cloak x-show="sortDropdown"
        x-on:click.away="sortDropdown = false" x-transition.scale.origin.top x-on:click="sortDropdown = false"
        class="bg-white shadow-lg text-sm text-gray-600 rounded-lg z-10 border-t border-gray-100 max-v-[50vh] overflow-y-auto w-[150px]">
        <button wire:click="setSortMethod('popularity')" type="button" x-on:click="selectedSort = 'popularity'"
            class="flex items-center gap-3 size-full px-5 py-4 hover:bg-gray-100">
            <x-icons.heart-off size="22" class="text-pink-400" />
            <span>
                Popüler
            </span>
        </button>
        <button wire:click="setSortMethod('newest')" type="button" x-on:click="selectedSort = 'newest'"
            class="flex items-center gap-3 size-full px-5 py-4 hover:bg-gray-100">
            <x-icons.hot size="22" class="text-orange-400" />
            <span>
                Yeni
            </span>
        </button>
        <button wire:click="setSortMethod('oldest')" type="button" x-on:click="selectedSort = 'oldest'"
            class="flex items-center gap-3 size-full px-5 py-4 hover:bg-gray-100">
            <x-icons.hourglass size="22" class="text-primary" />
            <span>
                Eski
            </span>
        </button>
    </div>
</div>
