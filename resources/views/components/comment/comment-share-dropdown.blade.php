@props(['comment_url', 'reply_url', 'commentable'])
<div class="rounded-md w-min border border-gray-100 overflow-hidden bg-white text-sm text-gray-800 shadow-lg z-10"
    x-anchor.offset.3.bottom-start="$refs.shareButton" x-cloak x-show="openShareDropdown"
    x-on:click.outside="openShareDropdown = false" x-transition.scale.origin.top>
    <button x-data="{ copyFeedback: 'Yorum bağlantısı' }"
        x-on:click="
                $clipboard('{{ $comment_url }}');
                Toaster.success('Yorum bağlantısı kopyalandı!');
                openShareDropdown = false;
            "
        class="inline-flex w-full items-center gap-2.5 px-2.5 py-2 md:px-4 md:py-3 text-xs font-bold text-gray-800 hover:bg-gray-100 hover:no-underline">
        <x-tabler-link class="size-5 shrink-0" />
        <span x-text="copyFeedback" class="text-left whitespace-nowrap"></span>
    </button>
    @if ($commentable == 'comment')
        <button x-data="{ copyFeedback: 'Yanıt bağlantısı' }"
            x-on:click="
                $clipboard('{{ $reply_url }}');
                Toaster.success('Yanıt bağlantısı kopyalandı!');
                openShareDropdown = false;
            "
            class="inline-flex w-full items-center gap-2.5 px-2.5 py-2 md:px-4 md:py-3 text-xs font-bold text-gray-800 hover:bg-gray-100 hover:no-underline">
            <x-tabler-link class="size-5 shrink-0" />
            <span x-text="copyFeedback" class="text-left whitespace-nowrap"></span>
        </button>
    @endif
    <x-link href="{{ $comment_url }}"
        class="inline-flex w-full items-center gap-2.5 px-2.5 py-2 md:px-4 md:py-3 text-xs font-bold text-gray-800 hover:bg-gray-100 hover:no-underline">
        <x-tabler-route-alt-right class="size-5 shrink-0" />
        <span>Yoruma git</span>
    </x-link>
</div>
