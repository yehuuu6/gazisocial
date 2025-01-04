<x-modal wire:modal="shareModal">
    <x-slot name="title">
        <h1 class="text-lg font-medium p-4 text-gray-700">Gönderiyi Paylaş</h1>
    </x-slot>
    <x-slot name="body">
        <div class="m-4 flex items-center gap-3">
            <a target="_blank" href="https://api.whatsapp.com/send?text={{ urlencode($post->showRoute()) }}"
                class="overflow-hidden rounded-full p-3 grid place-items-center text-gray-200 shadow-lg bg-green-500 duration-300 transition-all hover:scale-105">
                <x-icons.whatsapp size="30" />
            </a>
            <a target="_blank" href="https://x.com/intent/post?url={{ urlencode($post->showRoute()) }}"
                class="overflow-hidden rounded-full p-3 grid place-items-center text-gray-200 shadow-lg bg-black duration-300 transition-all hover:scale-105">
                <x-icons.x size="30" />
            </a>
            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($post->showRoute()) }}"
                class="overflow-hidden rounded-full p-3 grid place-items-center shadow-lg bg-blue-600 text-gray-200 duration-300 transition-all hover:scale-105">
                <x-icons.facebook size="30" />
            </a>
        </div>
        <div class="m-4 flex items-center gap-2 bg-gray-100 rounded-md border border-gray-300">
            <input type="text" readonly id="post-url"
                class="text-gray-500 bg-transparent text-sm font-medium w-full px-6 py-4 outline-none"
                value="{{ $post->showRoute() }}" />
            <div x-data="{
                copyText: '{{ $post->showRoute() }}',
                copyNotification: false,
                copyToClipboard() {
                    $clipboard(this.copyText);
                    this.copyNotification = true;
                    let that = this;
                    setTimeout(function() {
                        that.copyNotification = false;
                    }, 3000);
                }
            }" class="relative z-20 mr-4 flex items-center">
                <button @click="copyToClipboard();"
                    class="flex items-center px-3 h-8 py-1 text-xs bg-white border rounded-md cursor-pointer border-neutral-200/60 hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none text-neutral-500 hover:text-neutral-600 group">
                    <span x-show="!copyNotification">Kopyala</span>
                    <svg x-show="!copyNotification" class="w-4 h-4 ml-1.5 stroke-current"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    <span x-show="copyNotification" class="tracking-tight text-green-500" x-cloak>Kopyalandı</span>
                    <svg x-show="copyNotification" class="w-4 h-4 ml-1.5 text-green-500 stroke-current"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                    </svg>
                </button>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        <div class="bg-gray-50 p-6 flex items-center justify-end">
            <button x-on:click="shareModal = false" type="button"
                class="rounded bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
                Kapat
            </button>
        </div>
    </x-slot>
</x-modal>
