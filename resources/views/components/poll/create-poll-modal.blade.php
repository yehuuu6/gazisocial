<div wire:show="showCreatePollModal" wire:transition.opacity x-cloak
    class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 grid place-items-center transition-all duration-300 ease-in-out">
    <div wire:show="showCreatePollModal" wire:transition.scale
        class="rounded-xl overflow-hidden shadow-lg bg-white relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full h-fit transform transition-all duration-300">
        <div class="bg-gradient-to-r from-teal-500 to-teal-400 text-white">
            <h3 class="px-6 py-4 text-lg font-semibold text-white flex items-center gap-2">
                <x-tabler-file-analytics class="size-6" />
                Anket Oluştur
            </h3>
        </div>
        <div>
            <form wire:submit="savePoll">
                <div class="px-6 py-4">
                    <div class="mb-4">
                        <label for="question" class="font-medium text-gray-700 block mb-1.5">
                            Soru
                        </label>
                        <input wire:model="question" type="text" id="question" name="question" required
                            class="outline-none border border-gray-300 rounded-lg p-2.5 text-sm text-gray-700 w-full focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all duration-200"
                            placeholder="Anket sorusu" autocomplete="off" spellcheck="false" />
                    </div>
                    <div class="flex items-center justify-between gap-5 mb-3">
                        <h4 class="font-medium text-gray-700 flex items-center gap-1.5">
                            <x-tabler-list class="size-5" />
                            Seçenekler
                        </h4>
                        <div class="flex items-center gap-2">
                            <button x-on:click="addOption()" type="button"
                                class="text-teal-500 text-sm font-medium hover:text-teal-600 transition-colors duration-200 flex items-center gap-1">
                                <x-tabler-plus class="size-4" />
                                Ekle
                            </button>
                            <button x-on:click="removeOption()" type="button"
                                class="text-red-500 text-sm font-medium hover:text-red-600 transition-colors duration-200 flex items-center gap-1">
                                <x-tabler-minus class="size-4" />
                                Sil
                            </button>
                        </div>
                    </div>
                    <div class="max-h-44 overflow-y-auto overflow-x-hidden rounded-lg border border-gray-200 p-2">
                        <ul class="space-y-2">
                            <template x-for="i in optionsCount" :key="i">
                                <li class="relative group">
                                    <input type="text" name="options[]" required data-option :id="'option-' + i"
                                        autocomplete="off" spellcheck="false" required
                                        x-on:clear-options.window="$el.value = ''"
                                        class="outline-none border border-gray-300 rounded-lg p-2.5 text-sm text-gray-700 w-full focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all duration-200 pl-8"
                                        :placeholder="'Seçenek ' + i" />
                                    <div
                                        class="absolute left-2.5 top-1/2 -translate-y-1/2 text-teal-500 font-medium text-sm">
                                        <span x-text="i"></span>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <div class="bg-gray-50 p-5 flex gap-2 items-center justify-end border-t border-gray-100">
                <button x-on:click="$wire.showCreatePollModal = false; $wire.question = ''" type="button"
                    class="rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 transition-colors duration-200">
                    İptal
                </button>
                <button x-on:click="saveOptions()" type="button"
                    class="rounded bg-teal-500 px-4 py-2 text-sm font-medium text-white hover:bg-teal-600 transition-colors duration-200 shadow-sm hover:shadow">
                    Ekle
                </button>
            </div>
        </div>
    </div>
</div>
