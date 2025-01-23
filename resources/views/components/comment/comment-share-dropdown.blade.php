@props(['url'])
<div class="rounded-md border w-40 md:w-48 border-gray-100 overflow-hidden bg-white text-sm text-gray-800 shadow-lg z-10"
    x-anchor.offset.3.bottom-start="$refs.shareButton" x-cloak x-show="openShareDropdown"
    x-on:click.away="openShareDropdown = false" x-transition.scale.origin.top>
    <button x-data="{ copyFeedback: 'Bağlantıyı kopyala' }"
        x-on:click="
            $clipboard('{{ $url }}');
            $nextTick(() => {
                copyFeedback = 'Kopyalandı!';
                setTimeout(() =>{
                    openShareDropdown = false;
                    copyFeedback = 'Bağlantıyı kopyala';
                }, 750);
            });
    "
        class="flex w-full items-center px-2.5 py-2 gap-2.5 md:px-4 md:py-3 text-xs md:text-sm font-medium text-gray-800 hover:bg-gray-100 hover:no-underline">
        <x-icons.copy size="18" />
        <span x-text="copyFeedback">Bağlantıyı kopyala</span>
    </button>
    <x-link href="{{ $url }}"
        class="flex w-full items-center px-2.5 py-2 gap-2.5 md:px-4 md:py-3 text-xs md:text-sm font-medium text-gray-800 hover:bg-gray-100 hover:no-underline">
        <x-icons.fork-right size="18" />
        <span>Yoruma git</span>
    </x-link>
</div>
