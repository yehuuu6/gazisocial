<div wire:show="$parent.showLastWill" wire:transition.opacity x-cloak
    class="fixed inset-0 bg-black bg-opacity-60 z-50 grid place-items-center">
    <div wire:show="$parent.showLastWill" wire:transition.scale
        class="rounded-lg overflow-hidden shadow-lg bg-white relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full border border-gray-200">
        <!-- Başlık -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-500 p-4">
            <h2 class="text-white font-bold text-lg flex items-center gap-2">
                <x-tabler-notebook class="size-5" />
                Vasiyetname
            </h2>
        </div>

        <div class="p-5">
            <p class="text-gray-600 text-sm mb-4 bg-purple-50 p-3 rounded-lg border border-purple-100">
                Vasiyetiniz siz öldükten sonra diğer oyuncular tarafından okunabilir.
            </p>

            <textarea wire:model="lastWill" spellcheck="false" maxlength="1000"
                class="w-full min-h-[200px] max-h-[275px] bg-gray-50 text-gray-600 resize-none border border-gray-200 rounded-lg p-3 outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm"
                placeholder="Vasiyetinizi buraya yazabilirsiniz..."></textarea>

            <div class="flex items-center justify-between gap-2 mt-4">
                <div></div>
                <h3 class="text-orange-500 text-sm font-medium bg-orange-50 px-3 py-1 rounded-full" wire:dirty>
                    Kaydedilmemiş değişiklikler var!
                </h3>
                <div class="flex items-center gap-2">
                    <x-ui.tooltip text="Sohbete Gönder" position="left">
                        <button x-on:click="$wire.$parent.showLastWill = false; $wire.call('sendLastWillToChat')"
                            class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 rounded-lg p-2 text-white transition-all shadow-sm flex items-center">
                            <x-tabler-message-circle class="size-5" />
                        </button>
                    </x-ui.tooltip>
                    <x-ui.tooltip text="Kaydet ve Kapat" position="left">
                        <button x-on:click="$wire.$parent.showLastWill = false; $wire.call('saveLastWill')"
                            class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 rounded-lg p-2 text-white transition-all shadow-sm flex items-center">
                            <x-tabler-check class="size-5" />
                        </button>
                    </x-ui.tooltip>
                </div>
            </div>
        </div>

        <!-- Kapatma butonu -->
        <button x-on:click="$wire.$parent.showLastWill = false; $wire.call('saveLastWill')"
            class="absolute top-3 right-3 text-white hover:text-gray-200 transition-all">
            <x-tabler-x class="size-5" />
        </button>
    </div>
</div>
