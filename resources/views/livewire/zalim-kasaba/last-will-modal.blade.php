<div wire:show="$parent.showLastWill" wire:transition.opacity x-cloak
    class="fixed inset-0 bg-black bg-opacity-60 z-50 grid place-items-center">
    <div wire:show="$parent.showLastWill" wire:transition.scale
        class="rounded-md overflow-hidden shadow bg-white p-6 relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full h-fit">
        <button x-on:click="$wire.$parent.showLastWill = false; $wire.call('saveLastWill')"
            class="flex items-center absolute top-2 right-2 justify-center p-1 md:p-2 bg-gray-100 hover:bg-gray-200 rounded-md text-gray-700">
            <x-icons.close size="20" />
        </button>
        <h3 class="text-gray-800 text-xl font-bold font-ginto flex-grow">
            Vasiyetname
        </h3>
        <p class="text-gray-500 text-sm mb-2 mt-0.5">
            Vasiyetiniz siz öldükten sonra diğer oyuncular tarafından okunabilir.
        </p>
        <textarea wire:model="lastWill" spellcheck="false" maxlength="1000"
            class="w-full min-h-[200px] max-h-[275px] bg-gray-50 text-gray-600 resize-none border border-gray-300 rounded-md p-2 outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
            placeholder="Vasiyetinizi buraya yazabilirsiniz..."></textarea>
        <div class="flex items-center justify-between gap-2 mt-2">
            <div></div>
            <h3 class="text-orange-400 text-sm font-medium flex-grow" wire:dirty>
                Kaydedilmemiş değişiklikler var!
            </h3>
            <x-ui.tooltip text="Sohbete Gönder" position="left">
                <button x-on:click="$wire.$parent.showLastWill = false; $wire.call('sendLastWillToChat')"
                    class="flex items-center justify-center p-1 md:p-2 bg-gray-100 hover:bg-gray-200 rounded-md text-gray-700">
                    <x-icons.chat-bubble size="20" />
                </button>
            </x-ui.tooltip>
        </div>
    </div>
</div>
