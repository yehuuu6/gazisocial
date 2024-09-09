<form wire:submit="createPoll" class="rounded-lg shadow-md">
    @csrf
    <h3 class="text-xl py-4 px-6 text-gray-700 font-medium">Anket oluştur</h3>
    <x-seperator />
    <div class="p-6 space-y-2">
        <label for="question" class="block text-sm font-medium text-gray-700">Soru</label>
        <input wire:model="question" type="text" id="question" name="question"
            placeholder="Anketiniz için bir soru girin"
            class="block w-full bg-gray-100 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            autocomplete="off" />
    </div>
    <x-seperator />
    <div class="p-6 space-y-2">
        <div class="flex items-end gap-1">
            <h3 class="block text-sm font-medium text-gray-700">Yanıtlar</h3>
            <button wire:click.prevent="addOption" type="button" class="text-sm text-blue-400">
                Ekle
            </button>
        </div>
        <div class="flex flex-col gap-3">
            @foreach ($optionInputs as $option)
                <div class="flex items-center gap-2">
                    <input wire:model="optionInputs.{{ $loop->index }}.option" type="text"
                        id="option-{{ $loop->index }}" name="option-{{ $loop->index }}"
                        class="block w-full bg-gray-100 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Yanıt {{ $loop->index + 1 }}" autocomplete="off" />
                    <button wire:click.prevent="removeOption({{ $loop->index }})" type="button" class="p-2">
                        <x-icons.trash color='#ff6969' size='14' />
                    </button>
                </div>
            @endforeach
        </div>
    </div>
    <x-seperator />
    <div class="bg-gray-50 p-4 gap-2 flex items-center justify-end">
        <button wire:click="$dispatch('closeModal')" type="button"
            class="px-4 py-2 font-medium outline-none text-sm text-red-500 rounded-md hover:bg-red-100">
            Vazgeç
        </button>
        <button type="submit"
            class="px-4 py-2 font-medium outline-none text-sm rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
            Ekle
        </button>
    </div>
</form>
