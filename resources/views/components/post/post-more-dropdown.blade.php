<div class="rounded-md border border-gray-100 overflow-hidden bg-white text-sm text-gray-800 shadow-lg z-10"
    x-anchor.offset.3.bottom-end="$refs.moreButton" x-cloak x-show="openMorePostButtons"
    x-on:click.outside="openMorePostButtons = false; confirmDelete = false" x-transition.scale.origin.top>
    @can('delete', $post)
        <template x-if="!confirmDelete">
            <button x-on:click="confirmDelete = true"
                class="flex w-full items-center px-2.5 py-2 gap-2.5 md:px-4 md:py-3 text-xs font-bold text-gray-800 hover:bg-gray-100 hover:no-underline">
                <x-icons.trash size="18" />
                <span>Sil</span>
            </button>
        </template>
        <template x-if="confirmDelete">
            <button wire:click="deletePost({{ $post->id }})" x-on:click="openMorePostButtons = false ;"
                class="flex w-full items-center px-2.5 py-2 gap-2.5 md:px-4 md:py-3 text-xs font-bold text-red-600 hover:bg-gray-100 hover:no-underline">
                <x-icons.trash size="18" />
                <span>Onayla</span>
            </button>
        </template>
    @endcan
</div>
