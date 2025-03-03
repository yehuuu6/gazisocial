<x-modal wire:modal="openPollModal{{ $poll->id }}">
    <x-slot name="title">
        <h1 class="text-lg font-medium p-4 text-gray-700 flex items-center gap-2 justify-between">
            Anket
            <div class="text-red-500 font-bold text-sm flex items-center gap-1">
                <span class="size-2 rounded-full bg-red-500"></span>
                CANLI
            </div>
        </h1>
    </x-slot>
    <x-slot name="body">
        <div class="flex flex-col gap-4 p-4" x-data="{ selectedOption: $wire.entangle('selectedOption') }">
            <div class="flex flex-col gap-2">
                <h4 class="text-base font-medium text-gray-700">{{ $poll->question }}</h4>
                <div class="flex flex-col gap-2">
                    @foreach ($poll->options as $option)
                        <button
                            :class="{
                                'border-green-500': selectedOption == {{ $option->id }},
                                'border-gray-200': selectedOption != {{ $option->id }}
                            }"
                            type="button" wire:click="vote({{ $option->id }})"
                            class="flex flex-col gap-1 px-3 py-1.5 rounded-md border-2 w-full cursor-pointer hover:bg-gray-50">
                            <h3 class="text-gray-700 text-sm flex items-center justify-between">
                                {{ $option->option }}
                                <span class="text-sm text-gray-500">
                                    {{ $this->getPollPercentage($poll, $option) }}%
                                </span>
                            </h3>
                            <div class="h-2 bg-gray-200 rounded-full mt-1">
                                <div class="h-full bg-green-500 rounded-full transition-all duration-300"
                                    style="width: {{ $this->getPollPercentage($poll, $option) }}%">
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        <div class="bg-gray-50 p-6 flex items-center justify-end">
            <button x-on:click="openPollModal{{ $poll->id }} = false" type="button"
                class="rounded bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
                Kapat
            </button>
        </div>
    </x-slot>
</x-modal>
