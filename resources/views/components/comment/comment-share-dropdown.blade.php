@props(['comment_url', 'reply_url', 'commentable'])
<div class="rounded-md border w-min border-gray-100 overflow-hidden bg-white text-sm text-gray-800 shadow-lg z-10"
    x-anchor.offset.3.bottom-start="$refs.shareButton" x-cloak x-show="openShareDropdown"
    x-on:click.outside="openShareDropdown = false" x-transition.scale.origin.top>
    <button x-data="{ copyFeedback: 'Yorum olarak kopyala' }"
        x-on:click="
                $clipboard('{{ $comment_url }}');
                $nextTick(() => {
                    copyFeedback = 'Kopyalandı!';
                    setTimeout(() => {
                        openShareDropdown = false;
                        copyFeedback = 'Yorum olarak kopyala';
                    }, 750);
                });
            "
        class="inline-flex w-full items-center gap-2.5 px-2.5 py-2 md:px-4 md:py-3 text-xs md:text-sm font-medium text-gray-800 hover:bg-gray-100 hover:no-underline">
        <x-icons.copy size="18" class="shrink-0" />
        <span x-text="copyFeedback" class="text-left whitespace-nowrap min-w-[125px] md:min-w-[150px]"></span>
    </button>
    @if ($commentable == 'comment')
        <button x-data="{ copyFeedback: 'Yanıt olarak kopyala' }"
            x-on:click="
                $clipboard('{{ $reply_url }}');
                $nextTick(() => {
                    copyFeedback = 'Kopyalandı!';
                    setTimeout(() => {
                        openShareDropdown = false;
                        copyFeedback = 'Yanıt olarak kopyala';
                    }, 750);
                });
            "
            class="inline-flex w-full items-center gap-2.5 px-2.5 py-2 md:px-4 md:py-3 text-xs md:text-sm font-medium text-gray-800 hover:bg-gray-100 hover:no-underline">
            <x-icons.copy size="18" class="shrink-0" />
            <span x-text="copyFeedback" class="text-left whitespace-nowrap min-w-[125px] md:min-w-[150px]"></span>
        </button>
    @endif
    <x-link href="{{ $comment_url }}"
        class="inline-flex w-full items-center gap-2.5 px-2.5 py-2 md:px-4 md:py-3 text-xs md:text-sm font-medium text-gray-800 hover:bg-gray-100 hover:no-underline">
        <x-icons.fork-right size="18" />
        <span>Yoruma git</span>
    </x-link>
</div>
