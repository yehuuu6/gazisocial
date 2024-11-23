<x-modals.modal-wrapper x-show="createPollModal" x-on:poll-created.window="createPollModal = false">
    <x-modals.modal-inner-wrapper x-show="createPollModal" @click.away="createPollModal = false">
        <form wire:submit="createPoll" class="rounded-lg">
            @csrf
            <h3 class="px-6 py-4 text-xl font-medium text-gray-700">Anket oluştur</h3>
            <x-seperator />

            <div class="flex flex-col gap-2 px-6 py-3">
                <label for="question" class="block text-sm font-medium text-gray-700">Soru</label>
                <input wire:model="question" type="text" id="question" name="question"
                    placeholder="Anketiniz için bir soru girin" required
                    class="block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    autocomplete="off" />
            </div>
            <div class="flex flex-col gap-2 bg-gray-50 px-6 py-3" x-data="{ options: $wire.entangle('optionInputs') }">
                <div class="flex items-center justify-between gap-1">
                    <h3 class="block text-sm font-medium text-gray-700">Yanıtlar</h3>
                    <div class="flex items-center gap-1">
                        <template x-if="options.length < 5">
                            <button x-on:click="options.push('')" type="button"
                                class="text-sm text-blue-400 hover:underline">
                                Ekle
                            </button>
                        </template>
                        <template x-if="options.length > 2">
                            <button x-on:click="options.pop()" type="button"
                                class="text-sm text-red-400 hover:underline">
                                Sil
                            </button>
                        </template>
                    </div>
                </div>
                <div class="flex flex-col gap-3" x-auto-animate.250ms>
                    <template x-for="(option, index) in options" :key="index">
                        <input type="text" :id="'options-' + index" placeholder="Yanıtınızı girin" required
                            x-model="options[index]"
                            class="block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                            autocomplete="off" />
                    </template>
                </div>
            </div>
            <x-seperator />
            <div class="flex items-center justify-end gap-2 bg-gray-50 p-4">
                <button type="button" @click="createPollModal = false"
                    class="rounded px-4 py-2 font-medium text-red-500 outline-none hover:bg-red-100">
                    Vazgeç
                </button>
                <button type="submit"
                    class="rounded bg-blue-500 px-6 py-2 font-medium text-white outline-none hover:bg-blue-600">
                    Oluştur
                </button>
            </div>
        </form>

    </x-modals.modal-inner-wrapper>
</x-modals.modal-wrapper>
