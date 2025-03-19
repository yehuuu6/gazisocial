<div wire:show="$parent.showPlayerLastWill" wire:transition.opacity x-cloak
    class="fixed inset-0 bg-black bg-opacity-60 z-50 grid place-items-center">
    <div wire:show="$parent.showPlayerLastWill" wire:transition.scale
        class="rounded-lg overflow-hidden shadow-lg bg-white relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full border border-gray-200">

        <!-- Başlık -->
        <div class="bg-gradient-to-r from-gray-700 to-gray-600 p-4">
            <h2 wire:text='title' class="text-white font-bold text-lg flex items-center gap-2">
                <x-icons.notebook-pen size="20" />
            </h2>
        </div>

        <!-- İçerik -->
        <div class="p-5">
            <div wire:loading.flex class="min-h-[250px] max-h-[350px] flex w-full items-center justify-center">
                <div class="text-blue-400 text-4xl">
                    <x-icons.spinner size="24" class="size-20" />
                </div>
            </div>

            <div wire:loading.remove>
                <textarea wire:text="lastWill" spellcheck="false" maxlength="1000" readonly
                    class="w-full min-h-[250px] max-h-[350px] bg-gray-50 text-gray-600 resize-none border border-gray-200 rounded-lg p-3 outline-none shadow-sm"
                    placeholder="Bu kişi vasiyet bırakmamış.">
                </textarea>
            </div>

            <!-- Alt kısım -->
            <div class="flex justify-end mt-4">
                <button x-on:click="$wire.$parent.showPlayerLastWill = false; $wire.call('unLoadLastWill')"
                    class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-4 py-2 rounded-lg font-medium shadow-sm transition-all flex items-center gap-2">
                    <x-icons.check size="20" />
                    Tamam
                </button>
            </div>
        </div>

        <!-- Kapatma butonu -->
        <button x-on:click="$wire.$parent.showPlayerLastWill = false; $wire.call('unLoadLastWill')"
            class="absolute top-3 right-3 text-white hover:text-gray-200 transition-all">
            <x-icons.close size="20" />
        </button>
    </div>
</div>
