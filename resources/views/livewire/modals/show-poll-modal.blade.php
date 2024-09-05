<div wire:poll.5s class="rounded-lg shadow-md">
    <div class="flex items-center justify-between">
        <h3 class="text-xl py-4 px-6 text-gray-700 font-medium">{{ $poll->question }} <span
                class="text-sm text-gray-500 font-normal">{{ $poll->votes->count() }} oy verildi.</span></h3>
        <div class="py-4 px-6 flex gap-1 items-center">
            <x-icons.dot color='#ff6969' size='12' />
            <h4 class="text-red-400 font-extrabold text-lg">CANLI</h4>
        </div>
    </div>
    <x-seperator />
    <div class="flex flex-col flex-grow gap-1">
        <div class="flex flex-col gap-2 px-6 py-4">
            @foreach ($poll->options as $option)
                @php
                    // Calculate percentage of votes with $poll->votes
                    $totalVotes = $poll->votes->count();
                    $optionVotes = $option->votes->count();
                    $percentage = $totalVotes > 0 ? round(($optionVotes / $totalVotes) * 100, 2) : 0;

                    // Set border class between gray and blue based on selectedOption and option->id

                    $borderClass =
                        $selectedOption && $selectedOption == $option->id ? 'border-blue-500' : 'border-gray-300';
                @endphp
                <div wire:key="option-{{ $option->id }}"
                    class="flex justify-between items-center transition-all duration-500 py-2 gap-1 px-3 bg-gray-50 rounded-md border-2 {{ $borderClass }}">
                    <div class="flex flex-col flex-grow pb-1 px-1">
                        <div class="flex items-center">
                            <div class="flex items-center cursor-pointer w-full">
                                <input type="radio" id="{{ $option->id }}" name="option"
                                    value="{{ $option->id }}" wire:click="selectOption({{ $option }})"
                                    {{ $selectedOption == $option->id ? 'checked' : '' }} class="size-4">
                                <label for="{{ $option->id }}"
                                    class="ml-2 cursor-pointer flex-1 flex items-center justify-between">
                                    <span class="text-gray-700">{{ $option->option }}</span>
                                    <span class="text-gray-500">{{ $percentage }}%</span>
                                </label>
                            </div>
                        </div>
                        <div class="w-full bg-gray-300 rounded-full h-2 mt-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-1000"
                                style="width: {{ $percentage }}%;"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <x-seperator />
    <div class="bg-gray-50 p-4 gap-2 flex items-center justify-end">
        <button wire:click="$dispatch('closeModal')" type="button"
            class="px-4 py-2 font-medium text-sm text-red-500 rounded-md hover:bg-red-100">
            Kapat
        </button>
    </div>
</div>
