<div wire:show="$parent.showPollModal" wire:transition.opacity x-cloak
    class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 grid place-items-center transition-all duration-300 ease-in-out">
    <div wire:show="$parent.showPollModal" wire:transition.scale
        class="rounded-xl overflow-hidden shadow-lg bg-white relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full h-fit transform transition-all duration-300">
        <div class="bg-gradient-to-r from-teal-500 to-teal-400 text-white">
            <h1 class="text-lg font-semibold p-4 flex items-center gap-2 flex-wrap break-all justify-between">
                <div class="flex items-center gap-2">
                    <x-icons.survey size="24" />
                    Ankete Katıl
                </div>
                <div class="text-white font-bold text-sm flex items-center gap-1 bg-red-600 px-2 py-0.5 rounded-full">
                    <span class="size-2 rounded-full bg-white"></span>
                    CANLI
                </div>
            </h1>
        </div>
        <div class="flex flex-col gap-4 px-6 pt-4 pb-4" x-data="{ selectedOption: $wire.entangle('selectedOption') }">
            @if ($poll)
                <h5 class="text-gray-800 text-base font-medium">
                    {{ $poll->question }}
                </h5>
                <p class="text-teal-500 text-xs font-medium flex items-center gap-1.5">
                    <x-icons.votes size="18" />
                    Toplam {{ $poll->votes_count }} oy kullanıldı
                </p>
                <div class="flex flex-col gap-3">
                    @foreach ($poll->options as $option)
                        <button
                            :class="{
                                'border-teal-300 bg-teal-50': selectedOption == {{ $option->id }},
                                'border-gray-200 hover:border-teal-500 hover:bg-gray-50': selectedOption !=
                                    {{ $option->id }}
                            }"
                            type="button" wire:click="vote({{ $option->id }})"
                            class="flex flex-col gap-1 px-4 py-3 rounded-lg border-2 w-full cursor-pointer transition-all duration-200">
                            <h3 class="text-gray-700 text-sm flex items-center justify-between">
                                <div>
                                    <span class="font-medium">{{ $option->option }}</span>
                                    <span class="text-xs text-gray-500 ml-1">
                                        ({{ $option->votes_count }} Oy)
                                    </span>
                                </div>
                                <span class="text-sm font-bold"
                                    :class="{
                                        'text-teal-300': selectedOption ==
                                            {{ $option->id }},
                                        'text-gray-500': selectedOption != {{ $option->id }}
                                    }">
                                    {{ $this->getPollPercentage($poll, $option) }}%
                                </span>
                            </h3>
                            <div class="h-3 bg-gray-100 rounded-full mt-1.5 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500 ease-out"
                                    :class="{
                                        'bg-teal-300': selectedOption ==
                                            {{ $option->id }},
                                        'bg-teal-500': selectedOption != {{ $option->id }}
                                    }"
                                    style="width: {{ $this->getPollPercentage($poll, $option) }}%">
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="bg-gray-50 p-5 flex items-center justify-between border-t border-gray-100">
            <span class="text-xs text-gray-500">Oyunuzu istediğiniz zaman değiştirebilirsiniz</span>
            <button type="button" x-on:click="$wire.call('unloadPollData'); $wire.$parent.showPollModal = false"
                class="rounded bg-teal-500 px-4 py-2 text-sm font-medium text-white hover:bg-teal-600 transition-colors duration-200 shadow-sm hover:shadow">
                Kapat
            </button>
        </div>
    </div>
</div>
