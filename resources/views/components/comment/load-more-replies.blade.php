@props(['moreRepliesCount'])
<div class="relative mt-2.5 w-fit" x-cloak x-show="showReplies">
    <div class="absolute -top-3.5 left-4 border-b border-l rounded-bl-xl size-6 border-gray-200">
    </div>
    <div class="ml-10">
        <button wire:click='loadMoreReplies({{ $moreRepliesCount }})' wire:target="loadMoreReplies"
            wire:loading.attr="disabled" type="button" class="text-xs text-gray-700 hover:underline">
            <div class="flex items-center gap-2" wire:target="loadMoreReplies" wire:loading.remove>
                <x-icons.continue size="18" />
                <span>{{ $moreRepliesCount }} cevap daha</span>
            </div>
            <div wire:loading wire:target="loadMoreReplies" class="ml-10">
                <x-icons.spinner size="18" />
            </div>
        </button>
    </div>
</div>
