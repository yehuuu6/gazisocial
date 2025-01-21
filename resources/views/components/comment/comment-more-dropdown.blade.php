<div class="rounded-md border border-gray-100 overflow-hidden bg-white text-sm text-gray-800 shadow-lg z-10"
    x-anchor.offset.3.bottom-end="$refs.moreButton" x-cloak x-show="openMoreCommentButtons"
    x-on:click.away="openMoreCommentButtons = false" x-transition.scale.origin.top>
    <button x-on:click="alert('Not implemented yet!'); openMoreCommentButtons = false"
        class="flex w-full items-center gap-2.5 px-4 py-3 text-sm font-medium text-gray-800 hover:bg-gray-100 hover:no-underline">
        <x-icons.report size="18" />
        <span>Bildir</span>
    </button>
    @can('delete', $comment)
        <button wire:click="$parent.deleteComment({{ $comment->id }})" x-on:click="openMoreCommentButtons = false ;"
            class="flex w-full items-center gap-2.5 px-4 py-3 text-sm font-medium text-gray-800 hover:bg-gray-100 hover:no-underline">
            <x-icons.trash size="18" />
            <span>Sil</span>
        </button>
    @endcan
</div>
