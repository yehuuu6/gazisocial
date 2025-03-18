@props(['url'])

<div wire:show="showShareModal" wire:transition.opacity x-cloak
    class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 grid place-items-center transition-all duration-300 ease-in-out">
    <div wire:show="showShareModal" wire:transition.scale
        class="rounded-xl overflow-hidden shadow-lg bg-white relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full h-fit transform transition-all duration-300">
        <div class="bg-gradient-to-r from-green-500 to-green-400 text-white">
            <h3 class="px-6 py-4 text-lg font-semibold text-white flex items-center gap-2">
                <x-icons.share size="24" />
                Gönderiyi Paylaş
            </h3>
        </div>
        <div class="p-6">
            <h4 class="text-gray-700 text-sm font-medium mb-4">Sosyal Medyada Paylaş</h4>
            <div class="flex items-center justify-center gap-4 mb-6">
                <a target="_blank" href="https://api.whatsapp.com/send?text={{ urlencode($url) }}"
                    class="flex flex-col items-center gap-2 group">
                    <div
                        class="overflow-hidden rounded-full p-3.5 grid place-items-center text-white shadow-md bg-green-500 transition-all duration-300 hover:shadow-lg group-hover:scale-110">
                        <x-icons.whatsapp size="26" />
                    </div>
                    <span
                        class="text-xs font-medium text-gray-600 group-hover:text-green-600 transition-colors">WhatsApp</span>
                </a>
                <a target="_blank" href="https://x.com/intent/post?url={{ urlencode($url) }}"
                    class="flex flex-col items-center gap-2 group">
                    <div
                        class="overflow-hidden rounded-full p-3.5 grid place-items-center text-white shadow-md bg-black transition-all duration-300 hover:shadow-lg group-hover:scale-110">
                        <x-icons.x size="26" />
                    </div>
                    <span
                        class="text-xs font-medium text-gray-600 group-hover:text-gray-900 transition-colors">Twitter</span>
                </a>
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
                    class="flex flex-col items-center gap-2 group">
                    <div
                        class="overflow-hidden rounded-full p-3.5 grid place-items-center shadow-md bg-blue-600 text-white transition-all duration-300 hover:shadow-lg group-hover:scale-110">
                        <x-icons.facebook size="26" />
                    </div>
                    <span
                        class="text-xs font-medium text-gray-600 group-hover:text-blue-600 transition-colors">Facebook</span>
                </a>
            </div>
            <h4 class="text-gray-700 text-sm font-medium mb-3">Bağlantıyı Kopyala</h4>
            <div class="flex items-center gap-2 bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                <input type="text" readonly id="post-url"
                    class="text-gray-500 bg-transparent text-sm w-full px-4 py-3 outline-none flex-1"
                    value="{{ $url }}" />
                <div x-data="{
                    copyText: '{{ $url }}',
                    copyNotification: false,
                    copyToClipboard() {
                        $clipboard(this.copyText);
                        this.copyNotification = true;
                        let that = this;
                        setTimeout(function() {
                            that.copyNotification = false;
                        }, 3000);
                    }
                }" class="relative z-20 mr-2 flex items-center">
                    <button x-on:click="copyToClipboard()"
                        class="flex items-center px-3 h-9 py-1 text-sm bg-white border rounded-md cursor-pointer border-gray-200 hover:bg-gray-50 active:bg-white focus:outline-none text-gray-700 hover:text-primary transition-colors duration-200 group shadow-sm">
                        <span x-show="!copyNotification">Kopyala</span>
                        <x-icons.copy x-show="!copyNotification" size="20"
                            class="ml-1.5 text-gray-500 group-hover:text-primary transition-colors" />
                        <span x-show="copyNotification" class="tracking-tight text-green-500 flex items-center gap-1"
                            x-cloak>
                            Kopyalandı
                            <x-icons.check-check size="20" class="text-green-500" />
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-gray-50 p-5 flex items-center justify-end border-t border-gray-100">
                <button type="button" x-on:click="$wire.showShareModal = false"
                    class="rounded bg-gray-200 hover:bg-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200">
                    Kapat
                </button>
            </div>
        </div>
    </div>
</div>
