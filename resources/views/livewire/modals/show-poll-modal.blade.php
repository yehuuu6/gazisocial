<x-modals.modal-wrapper x-show="showPollModal{{ $poll->id }}">
    <x-modals.modal-inner-wrapper x-show="showPollModal{{ $poll->id }}"
        x-on:click.away="showPollModal{{ $poll->id }} = false">
        <div class="bg-white">
            <div class="flex items-center justify-between">
                <h3 class="px-6 py-4 text-xl font-medium text-gray-700">
                    {{ $poll->question }}
                    <span class="text-sm font-normal text-gray-500">
                        Toplam {{ $poll->votes_count }} oy verildi.
                    </span>
                </h3>
                <div class="flex items-center gap-1 px-6 py-4">
                    <x-icons.dot color='#ff6969' size='12' />
                    <h4 class="text-base font-extrabold text-red-400 md:text-lg">CANLI</h4>
                </div>
            </div>
            <x-seperator />
            <div class="flex flex-grow flex-col gap-1">
                <div class="flex flex-col gap-2 px-6 py-4">
                    @foreach ($poll->options as $option)
                        <button wire:key="poll-option-{{ $option->id }}" type="button"
                            wire:click="vote({{ $option }})" @class([
                                'transition-all duration-300 border-blue-400 rounded-md border-2 px-4 py-2 hover:bg-gray-100 cursor-pointer' =>
                                    $option->id == $selectedOption,
                                'transition-all duration-300 border-gray-300 rounded-md border-2 px-4 py-2 hover:bg-gray-100 cursor-pointer' =>
                                    $option->id != $selectedOption,
                            ])">
                            <div class="flex items-center justify-between text-lg text-gray-700">
                                <div>
                                    <span class="text-base">{{ $option->option }}</span>
                                    <span class="text-sm text-gray-500">({{ $option->votes_count }} oy)</span>
                                </div>
                                <span class="text-sm text-gray-600">%{{ $option->percentage }}</span>
                            </div>
                            <div class="flex items-center mt-2">
                                <div class="w-full bg-gray-300 rounded-full">
                                    <div class="bg-blue-500 h-2 rounded-full transition-all duration-1000"
                                        style="width: {{ $option->percentage }}%">
                                    </div>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
            <x-seperator />
            <div class="flex items-center justify-end gap-2 bg-gray-50 p-4">
                <button type="button"
                    x-on:click="showPollModal{{ $poll->id }} = false;$dispatch('poll-modal-close')"
                    class="rounded px-4 py-2 font-medium text-red-500 outline-none hover:bg-red-100">
                    Kapat
                </button>
            </div>
        </div>
    </x-modals.modal-inner-wrapper>
</x-modals.modal-wrapper>
