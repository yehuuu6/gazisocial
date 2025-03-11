@props(['oldMessages', 'currentPlayer', 'selectedDayCount', 'lobby'])
<div wire:show="chatHistoryModal" wire:transition.scale
    class="flex rounded-md flex-col gap-2 overflow-hidden bg-white relative w-[525px] h-[375px]">
    <button type="button" class="absolute top-2 right-2 text-gray-700 hover:text-gray-500 p-1"
        x-on:click="$wire.chatHistoryModal = false">
        <x-icons.close size="20" />
    </button>
    <h3 class="text-xl pt-4 px-4 pb-1 text-center font-semibold text-gray-800">
        Geçmiş Mesajlar
    </h3>
    <div x-data="{
        historyDropdown: false,
    }" class="flex px-4 items-center justify-between">
        <button type="button" x-ref="historyDaySelector" x-on:click="historyDropdown = !historyDropdown"
            class="text-gray-800 justify-center rounded flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-300 text-sm font-medium">
            {{ $selectedDayCount }}. Gün <x-icons.arrow-down size="20" />
        </button>
        <div class="max-h-64 overflow-y-auto bg-white border border-gray-300 rounded shadow-md" x-show="historyDropdown"
            x-anchor.bottom-center.offset.5="$refs.historyDaySelector" x-cloak
            x-on:click.away="historyDropdown = false">
            @for ($i = 0; $i <= $lobby->day_count; $i++)
                <button type="button" wire:click="loadChatHistory({{ $i }})"
                    x-on:click="historyDropdown = false"
                    class="flex w-full items-center gap-1 px-4 py-2 bg-white hover:bg-gray-100 text-sm font-medium">
                    {{ $i }}. Gün
                </button>
            @endfor
        </div>
    </div>
    <div class="py-2">
        <x-seperator />
    </div>
    <div class="h-0 px-2 flex-1 overflow-y-auto bg-gray-50">
        <x-zalim-kasaba.chat-box :key="'old-chat'" :messages="$oldMessages" :currentPlayer="$currentPlayer" />
    </div>
</div>
