@props(['messages', 'currentPlayer', 'key' => 'msg'])
<div x-init="showLatestMessage(true)" id="chat-box" x-on:chat-message-received.window="showLatestMessage()"
    class="flex flex-col gap-2 flex-1 overflow-y-auto p-2">
    @forelse ($messages as $msg)
        @if (
            ($msg->faction === App\Enums\ZalimKasaba\ChatMessageFaction::MAFIA && !$currentPlayer->isMafia()) ||
                ($msg->faction === App\Enums\ZalimKasaba\ChatMessageFaction::DEAD && $currentPlayer->is_alive))
            @continue
        @endif
        <div wire:key="{{ $key }}-{{ $msg->id }}"
            class="flex flex-col gap-1 border border-gray-200 bg-white rounded-md py-2 px-3">
            <div class="flex items-center gap-1 text-xs font-semibold">
                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                    {{ $msg->created_at->format('H:i') }}
                </span>
                @if ($this->isDeadChat($msg))
                    <span class="bg-red-500 text-white px-3 py-1 rounded-full italic">
                        ÖLÜLER
                    </span>
                @elseif ($this->isMafiaChat($msg))
                    <span class="bg-red-500 text-white px-3 py-1 rounded-full">
                        MAFYA
                    </span>
                @endif
                @if ($msg->user === null && $msg->receiver_id === null)
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full">
                        SİSTEM
                    </span>
                @elseif ($msg->user === null && $msg->receiver_id !== null)
                    <span class="bg-indigo-500 text-white px-3 py-1 rounded-full">
                        SANA ÖZEL
                    </span>
                @else
                    <span class="bg-amber-500 text-white px-3 py-1 rounded-full">
                        {{ $msg->user->username }}
                    </span>
                @endif
            </div>
            <p :class="{
                'bg-white text-gray-600': '{{ $msg->type }}'
                === 'default',
                'bg-red-500 text-white': '{{ $msg->type }}'
                === 'warning',
                'bg-green-500 text-white': '{{ $msg->type }}'
                === 'success',
                '!text-gray-500 italic': {{ $this->isDeadChat($msg) ? 'true' : 'false' }}
            }"
                class="rounded px-1 break-all text-sm self-start">
                {{ $msg->message }}
            </p>
        </div>
    @empty
        <div class="text-center text-gray-500">
            Henüz mesaj yok.
        </div>
    @endforelse
</div>
