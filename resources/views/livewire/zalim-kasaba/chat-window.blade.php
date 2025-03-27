<div x-data="{
    sendMessage() {
            $wire.sendMessage();
        },
        showLatestMessage() {
            const chatBox = document.querySelector('#chat-box');
            $nextTick(() => {
                chatBox.scrollTop = chatBox.scrollHeight;
            });
        },
}" class="flex flex-col flex-1 h-0">
    <x-zalim-kasaba.chat-box :$messages :$currentPlayer />
    <div class="flex items-center gap-2 px-4 py-3 bg-white border-t border-gray-200 shadow-sm">
        <div class="relative flex-grow">
            <input x-on:keydown.enter="sendMessage()" type="text" wire:model="message"
                class="w-full px-4 py-2.5 bg-gray-50 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm transition-all"
                placeholder="Mesajınızı yazın...">
        </div>
        <div class="flex items-center gap-2">
            <x-ui.tooltip text="Sohbet Geçmişi" position="left">
                <button type="button" x-on:click="$wire.chatHistoryModal = true"
                    class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 rounded-lg p-2 text-white transition-all shadow-sm">
                    <x-icons.time size="20" />
                </button>
            </x-ui.tooltip>
            <button type="button" x-on:click="sendMessage()"
                class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 rounded-lg p-2 text-white transition-all shadow-sm">
                <x-icons.send size="20" />
            </button>
        </div>
    </div>

    <!-- Sohbet Geçmişi Modal -->
    <div wire:show="chatHistoryModal" wire:transition.opacity x-cloak
        class="fixed inset-0 bg-black bg-opacity-60 z-50 grid place-items-center">
        <div wire:show="chatHistoryModal" wire:transition.scale
            class="rounded-lg overflow-hidden shadow-lg bg-white relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full border border-gray-200">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-4 flex items-center justify-between">
                <h2 class="text-white font-bold text-lg">Sohbet Geçmişi</h2>
                <button type="button" class="text-white hover:text-gray-200"
                    x-on:click="$wire.chatHistoryModal = false">
                    <x-icons.close size="20" />
                </button>
            </div>
            <x-zalim-kasaba.chat-history :$currentPlayer :$oldMessages :$selectedDayCount :$lobby />
        </div>
    </div>
</div>
