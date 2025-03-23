<div class="rounded-md border border-gray-100 overflow-hidden bg-white text-sm text-gray-800 shadow-lg z-10"
    x-anchor.offset.3.bottom-end="$refs.moreButton" x-cloak x-show="openMoreCommentButtons"
    x-on:click.outside="openMoreCommentButtons = false" x-transition.scale.origin.top>
    @auth
        <button wire:click="reportComment()" x-on:click="openMoreCommentButtons = false ;"
            class="flex w-full items-center px-2.5 py-2 gap-2.5 md:px-4 md:py-3 text-xs md:text-sm font-medium text-gray-800 hover:bg-gray-100 hover:no-underline">
            <x-icons.report size="18" />
            <span>Bildir</span>
        </button>
    @endauth
    @can('delete', $comment)
        <button wire:click="$parent.deleteComment({{ $comment->id }})" x-on:click="openMoreCommentButtons = false ;"
            class="flex w-full items-center px-2.5 py-2 gap-2.5 md:px-4 md:py-3 text-xs md:text-sm font-medium text-gray-800 hover:bg-gray-100 hover:no-underline">
            <x-icons.trash size="18" />
            <span>Sil</span>
        </button>
    @endcan
</div>
