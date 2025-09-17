<div class="rounded-md border border-gray-100 overflow-hidden bg-white text-sm text-gray-800 shadow-lg z-10"
    x-anchor.offset.3.bottom-end="$refs.moreCommentButton" x-cloak x-show="openMoreCommentButtons"
    x-on:click.outside="openMoreCommentButtons = false; confirmDelete = false" x-transition.scale.origin.top>
    @can('delete', $comment)
        <template x-if="!confirmDelete">
            <button x-on:click="confirmDelete = true"
                class="inline-flex justify-center w-full items-center px-2.5 py-2 gap-2 md:px-4 md:py-3 text-sm font-bold text-gray-800 hover:bg-gray-100 hover:no-underline">
                <x-tabler-trash class="size-5 flex-shrink-0" />
                Sil
            </button>
        </template>
        <template x-if="confirmDelete">
            <button wire:click="deleteComment({{ $comment->id }})" x-on:click="openMoreCommentButtons = false ;"
                class="inline-flex justify-center w-full items-center px-2.5 py-2 gap-2 md:px-4 md:py-3 text-sm font-bold text-red-600 hover:bg-gray-100 hover:no-underline">
                <x-tabler-trash class="size-5 flex-shrink-0" />
                Onayla
            </button>
        </template>
    @endcan
</div>
