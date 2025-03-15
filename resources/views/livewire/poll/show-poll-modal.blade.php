<div wire:show="$parent.showPollModal" wire:transition.opacity x-cloak
    class="fixed inset-0 bg-black bg-opacity-60 z-50 grid place-items-center">
    <div wire:show="$parent.showPollModal" wire:transition.scale
        class="rounded-md overflow-hidden shadow bg-white relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full h-fit">
        <div>
            <h1
                class="text-lg font-medium p-4 text-gray-700 flex items-center gap-2 flex-wrap break-all justify-between">
                @if ($poll)
                    {{ $poll->question }}
                @endif
                <div class="text-red-500 font-bold text-sm flex items-center gap-1">
                    <span class="size-2 rounded-full bg-red-500"></span>
                    CANLI
                </div>
            </h1>
        </div>
        <div class="flex flex-col gap-4 p-4" x-data="{ selectedOption: $wire.entangle('selectedOption') }">
            @if ($poll)
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
            @endif
        </div>
        <div class="bg-gray-50 p-6 flex items-center justify-end">
            <button false" type="button" x-on:click="$wire.call('unloadPollData'); $wire.$parent.showPollModal = false"
                class="rounded bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
                Kapat
            </button>
        </div>
    </div>
</div>
