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
    <div class="flex items-center gap-1 px-2 py-3 bg-white border-t border-gray-200">
        <input x-on:keydown.enter="sendMessage()" type="text" wire:model="message"
            class="flex-grow px-4 py-2 bg-gray-50 text-sm border border-gray-200 rounded-full outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
            placeholder="Mesajınızı yazın...">
        <button type="button" x-on:click="sendMessage()"
            class="duration-300 bg-gradient-to-r from-lime-500 to-emerald-500 hover:from-emerald-400 hover:to-lime-600 rounded-full p-2 text-white transition-all transform hover:scale-105">
            <x-icons.send-msg size="20" />
        </button>
        <x-ui.tooltip text="Sohbet Geçmişi" position="left">
            <button type="button" x-on:click="$wire.chatHistoryModal = true"
                class="duration-300 bg-opacity-50 bg-gradient-to-r from-lime-500 to-emerald-500 hover:from-emerald-400 hover:to-lime-600 rounded-full p-2 text-white transition-all transform hover:scale-105">
                <svg width="20" height="20" viewBox="0 0 15 15" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M13.15 7.49998C13.15 4.66458 10.9402 1.84998 7.50002 1.84998C4.72167 1.84998 3.34849 3.9064 2.76335 5H4.5C4.77614 5 5 5.22386 5 5.5C5 5.77614 4.77614 6 4.5 6H1.5C1.22386 6 1 5.77614 1 5.5V2.5C1 2.22386 1.22386 2 1.5 2C1.77614 2 2 2.22386 2 2.5V4.31318C2.70453 3.07126 4.33406 0.849976 7.50002 0.849976C11.5628 0.849976 14.15 4.18537 14.15 7.49998C14.15 10.8146 11.5628 14.15 7.50002 14.15C5.55618 14.15 3.93778 13.3808 2.78548 12.2084C2.16852 11.5806 1.68668 10.839 1.35816 10.0407C1.25306 9.78536 1.37488 9.49315 1.63024 9.38806C1.8856 9.28296 2.17781 9.40478 2.2829 9.66014C2.56374 10.3425 2.97495 10.9745 3.4987 11.5074C4.47052 12.4963 5.83496 13.15 7.50002 13.15C10.9402 13.15 13.15 10.3354 13.15 7.49998ZM7.5 4.00001C7.77614 4.00001 8 4.22387 8 4.50001V7.29291L9.85355 9.14646C10.0488 9.34172 10.0488 9.65831 9.85355 9.85357C9.65829 10.0488 9.34171 10.0488 9.14645 9.85357L7.14645 7.85357C7.05268 7.7598 7 7.63262 7 7.50001V4.50001C7 4.22387 7.22386 4.00001 7.5 4.00001Z"
                        fill="currentColor" />
                </svg>
            </button>
        </x-ui.tooltip>
    </div>
    <div wire:show="chatHistoryModal" wire:transition.opacity x-cloak
        class="fixed inset-0 bg-black bg-opacity-60 z-50 grid place-items-center">
        <x-zalim-kasaba.chat-history :$currentPlayer :$oldMessages :$selectedDayCount :$lobby />
    </div>
</div>
