<div wire:show="showCreatePollModal" wire:transition.opacity x-cloak
    class="fixed inset-0 bg-black bg-opacity-60 z-50 grid place-items-center">
    <div wire:show="showCreatePollModal" wire:transition.scale
        class="rounded-md overflow-hidden shadow bg-white relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full h-fit">
        <div>
            <h3 class="px-6 py-4 text-xl font-medium text-gray-700">
                Anket Oluştur
            </h3>
        </div>
        <div>
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
                                    <input type="text" name="options[]" required data-option :id="'option-' + i"
                                        autocomplete="off" spellcheck="false" required
                                        class="outline-none border border-gray-200 rounded-md p-2 text-sm text-gray-700 w-full"
                                        :placeholder="'Seçenek ' + i" />
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <div class="bg-gray-50 p-6 flex gap-2 items-center justify-end">
                <button x-on:click="$wire.showCreatePollModal = false" type="button"
                    class="rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-300">
                    Kapat
                </button>
                <button x-on:click="saveOptions()" type="button"
                    class="rounded bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
                    Kaydet
                </button>
            </div>
        </div>
    </div>
</div>
