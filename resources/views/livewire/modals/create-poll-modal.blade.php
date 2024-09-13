<form wire:submit="createPoll" class="rounded-lg" enctype="multipart/form-data">
    @csrf
    <h3 class="text-xl py-4 px-6 text-gray-700 font-medium">Anket oluştur</h3>
    <x-seperator />
    <x-scrollable-wrapper class="min-h-[250px]">
        <div class="px-6 py-3 flex flex-col gap-2">
            <label for="question" class="block text-sm font-medium text-gray-700">Soru</label>
            <input wire:model="question" type="text" id="question" name="question"
                placeholder="Anketiniz için bir soru girin" required
                class="block w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                autocomplete="off" />
        </div>
        <div class="px-6 py-3 flex flex-col gap-2">
            <div class="flex items-end gap-1">
                <h3 class="block text-sm font-medium text-gray-700">Yanıtlar</h3>
                <button wire:click.prevent="addOption" type="button" class="text-sm text-blue-400 hover:underline">
                    Ekle
                </button>
            </div>
            <div class="flex flex-col gap-3">
                @foreach ($optionInputs as $option)
                    <div class="flex items-center gap-2">
                        <input wire:model="optionInputs.{{ $loop->index }}.option" type="text"
                            id="option-{{ $loop->index }}" name="option-{{ $loop->index }}" required
                            class="block w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Yanıt {{ $loop->index + 1 }}" autocomplete="off" />
                        <button wire:click.prevent="removeOption({{ $loop->index }})" type="button" class="p-2">
                            <x-icons.trash color='#ff6969' size='14' />
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </x-scrollable-wrapper>
    <x-seperator />
    <div class="bg-gray-50 p-4 gap-2 flex items-center justify-end">
        <button wire:click="$dispatch('closeModal')" type="button"
            class="px-4 py-2 outline-none font-medium text-red-500 rounded hover:bg-red-100">
            Vazgeç
        </button>
        <button type="submit"
            class="px-6 py-2 bg-blue-500 text-white outline-none font-medium rounded hover:bg-blue-600">
            Ekle
        </button>
    </div>
</form>
