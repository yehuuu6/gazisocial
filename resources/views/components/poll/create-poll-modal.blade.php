<x-modal {{ $attributes }}>
    <x-slot name="title">
        <h3 class="px-6 py-4 text-xl font-medium text-gray-700">
            Anket Oluştur
        </h3>
    </x-slot>
    <x-slot name="body">
        <form wire:submit="savePoll">
            <div class="px-6 py-3">
                <div class="mb-2">
                    <label for="question" class="font-medium text-gray-700">
                        Soru
                    </label>
                    <input wire:model="question" type="text" id="question" name="question" required
                        class="outline-none border border-gray-200 rounded-md p-2 text-sm text-gray-700 w-full"
                        placeholder="Anket sorusu" autocomplete="off" spellcheck="false" />
                </div>
                <div class="mb-2">
                    <div class="flex items-center justify-between gap-2">
                        <label for="end_date" class="font-medium text-gray-700">
                            Bitiş Tarihi
                        </label>
                        <x-ui.tooltip text="Süresiz Anket" position="left">
                            <button
                                x-on:click="$wire.set('end_date', null) ; Toaster.info('Anketiniz süresiz olarak ayarlandı.')"
                                type="button" class="text-red-400 text-sm font-medium hover:text-red-500">
                                Sonsuz
                            </button>
                        </x-ui.tooltip>
                    </div>
                    <x-ui.date-picker wire:model="end_date" />
                </div>
                <div class="flex items-center justify-between gap-5">
                    <h4 class="font-medium text-gray-700">
                        Seçenekler
                    </h4>
                    <div class="flex items-center gap-2">
                        <button x-on:click="addOption()" type="button"
                            class="text-blue-400 text-sm font-medium hover:text-blue-500">
                            Ekle
                        </button>
                        <button x-on:click="removeOption()" type="button"
                            class="text-red-400 text-sm font-medium hover:text-red-500">
                            Sil
                        </button>
                    </div>
                </div>
                <div class="max-h-44 overflow-y-auto overflow-x-hidden">
                    <ul class="space-y-2">
                        <template x-for="i in optionsCount" :key="i">
                            <li>
                                <input type="text" name="options[]" id="options" required data-option
                                    autocomplete="off" spellcheck="false" required
                                    class="outline-none border border-gray-200 rounded-md p-2 text-sm text-gray-700 w-full"
                                    :placeholder="'Seçenek ' + i" />
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </form>
    </x-slot>
    <x-slot name="footer">
        <div class="bg-gray-50 p-6 flex gap-2 items-center justify-end">
            <button x-on:click="openPollCreator = false" type="button"
                class="rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-300">
                Kapat
            </button>
            <button x-on:click="saveOptions()" type="button"
                class="rounded bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
                Kaydet
            </button>
        </div>
    </x-slot>
</x-modal>
