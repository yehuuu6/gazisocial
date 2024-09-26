<x-modals.modal-wrapper x-show="createPollModal" x-on:poll-created.window="createPollModal = false">
    <x-modals.modal-inner-wrapper x-show="createPollModal" @click.away="createPollModal = false">
        <form wire:submit="createPoll" class="rounded-lg">
            @csrf
            <h3 class="text-xl py-4 px-6 text-gray-700 font-medium">Anket oluştur</h3>
            <x-seperator />

            <div class="px-6 py-3 flex flex-col gap-2">
                <label for="question" class="block text-sm font-medium text-gray-700">Soru</label>
                <input wire:model="question" type="text" id="question" name="question"
                    placeholder="Anketiniz için bir soru girin" required
                    class="block w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    autocomplete="off" />
            </div>
            <div class="px-6 py-3 flex flex-col gap-2" x-data="{ options: $wire.optionInputs }">
                <div class="flex items-end gap-1">
                    <h3 class="block text-sm font-medium text-gray-700">Yanıtlar</h3>
                    <button x-on:click="options.push('')" type="button" class="text-sm text-blue-400 hover:underline">
                        Ekle
                    </button>
                </div>
                <div class="flex flex-col gap-3">
                    <template x-for="(option, index) in options" :key="index">
                        <div class="flex items-center gap-2">
                            <input type="text" :id="'options-' + index" placeholder="Yanıtınızı girin" required
                                x-model="options[index]"
                                class="block w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                autocomplete="off" />
                            <button x-on:click="options.splice(index, 1)" type="button"
                                class="text-sm text-red-400 hover:underline">
                                Sil
                            </button>
                        </div>
                    </template>
                </div>
            </div>
            <x-seperator />
            <div class="bg-gray-50 p-4 gap-2 flex items-center justify-end">
                <button type="button" @click="createPollModal = false"
                    class="px-4 py-2 outline-none font-medium text-red-500 rounded hover:bg-red-100">
                    Vazgeç
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-blue-500 text-white outline-none font-medium rounded hover:bg-blue-600">
                    Ekle
                </button>
            </div>
        </form>

    </x-modals.modal-inner-wrapper>
</x-modals.modal-wrapper>
