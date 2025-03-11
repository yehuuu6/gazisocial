<div wire:show="$parent.showPlayerLastWill" wire:transition.opacity x-cloak
    class="fixed inset-0 bg-black bg-opacity-60 z-30 grid place-items-center">
    <div wire:show="$parent.showPlayerLastWill" wire:transition.scale
        class="rounded-md overflow-hidden shadow bg-white p-6 relative max-w-lg w-full h-fit">
        <div wire:loading.flex class="h-[350px] flex w-full items-center justify-center">
            <div class="text-blue-400 text-4xl">
                <x-icons.spinner size="24" class="size-20" />
            </div>
        </div>
        <div wire:loading.remove>
            <h3 wire:text='title' class="text-gray-800 text-xl font-bold font-ginto flex-grow">
            </h3>
            <button x-on:click="$wire.$parent.showPlayerLastWill = false; $wire.call('unLoadLastWill')"
                class="flex items-center justify-center p-2 bg-gray-100 hover:bg-gray-200 rounded-md text-gray-700 absolute top-2 right-2">
                <x-icons.close size="20" />
            </button>
            <textarea wire:text="lastWill" spellcheck="false" maxlength="1000" readonly
                class="w-full min-h-[350px] bg-gray-50 text-gray-600 resize-none border border-gray-300 rounded-md p-2 outline-none"
                placeholder="Bu kişi vasiyet bırakmamış.">
        </textarea>
        </div>
    </div>
</div>
