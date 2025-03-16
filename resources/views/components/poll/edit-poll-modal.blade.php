@props(['poll', 'options', 'optionsCount', 'question'])

<div wire:show="showEditPollModal" wire:transition.opacity x-cloak x-data="{
    initOptions() {
        this.$nextTick(() => {
            const inputs = document.querySelectorAll('[data-option]');
            const options = @js($options ?? []);
            inputs.forEach((input, index) => {
                if (options[index]) {
                    input.value = options[index];
                }
            });
        });
    }
}" x-init="initOptions"
    class="fixed inset-0 bg-black bg-opacity-60 z-50 grid place-items-center">
    <div wire:show="showEditPollModal" wire:transition.scale
        class="rounded-xl overflow-hidden shadow-xl bg-white relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full h-fit">
        <div>
            <h3 class="px-6 py-4 text-xl font-medium text-gray-700 border-b border-gray-100">
                Anketi Düzenle
            </h3>
        </div>
        <div>
            <form wire:submit.prevent="updatePoll">
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
                            <button type="button" wire:click="$set('optionsCount', Math.min(optionsCount + 1, 10))"
                                class="text-blue-400 text-sm font-medium hover:text-blue-500">
                                Ekle
                            </button>
                        </div>
                    </div>
                    <div class="max-h-44 overflow-y-auto overflow-x-hidden">
                        <ul class="space-y-2">
                            @for ($i = 0; $i < $optionsCount; $i++)
                                <li class="flex items-center gap-2">
                                    <input type="text" wire:model="options.{{ $i }}" required data-option
                                        autocomplete="off" spellcheck="false"
                                        class="outline-none border border-gray-200 rounded-md p-2 text-sm text-gray-700 w-full"
                                        placeholder="Seçenek {{ $i + 1 }}" />
                                    <button type="button" wire:click="deleteOption({{ $i }})"
                                        class="shrink-0 text-gray-400 hover:text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-colors">
                                        <x-icons.trash size="14" />
                                    </button>
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <div class="bg-gray-50 p-6 flex gap-2 items-center justify-end">
                <button type="button" x-on:click="$wire.showEditPollModal = false; $wire.question = ''"
                    class="rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-300">
                    Kapat
                </button>
                <button wire:click="updatePoll" type="button"
                    class="rounded bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
                    Güncelle
                </button>
            </div>
        </div>
    </div>
</div>
