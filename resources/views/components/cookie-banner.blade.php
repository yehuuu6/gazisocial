<div x-data="{
    show: false,
    init() {
        // Delay showing the banner by 2 seconds after page load
        setTimeout(() => {
            this.show = localStorage.getItem('cookie-consent') !== 'accepted';
        }, 2000);
    },
    accept() {
        localStorage.setItem('cookie-consent', 'accepted');
        this.show = false;
    }
}" x-show="show" x-transition:enter="transition ease-out duration-300" x-cloak
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-4"
    class="fixed shadow border-t border-gray-200 bottom-0 w-full z-50 bg-white px-4 py-3">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="text-gray-800 flex-shrink-0">
                <x-icons.cookie size="20" />
            </div>
            <p class="text-xs md:text-sm text-gray-700 mt-1">
                Size daha iyi bir deneyim sunmak için çerezleri kullanıyoruz.
                <a class="text-blue-500 hover:underline" href="{{ route('privacy') }}">Daha fazla bilgi</a>
            </p>
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <button x-on:click="accept()"
                class="py-1.5 px-4 bg-blue-600 hover:bg-blue-700 text-white text-xs md:text-sm font-medium rounded-md transition-colors duration-200 flex-grow md:flex-grow-0">
                Tamam
            </button>
        </div>
    </div>
</div>
