<form wire:submit="addReply({{ $comment->id }})" x-data="{ message: '' }">
    <div class="rounded-3xl border border-gray-300 bg-white py-2.5 px-4 pr-0 ml-3 md:ml-10 my-3 overflow-hidden">
        <textarea x-model="message" spellcheck="false" class="resize-y text-sm text-gray-600 w-full outline-none pt-1"
            wire:model="content" id="content" name="content" rows="2" maxlength="1000" x-trap="replyForm" required></textarea>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-1">
                <span
                    :class="{
                        'text-red-500': message.length >= 1000,
                        'text-yellow-500': message.length >= 750 && message.length < 1000,
                        'text-gray-500': message.length < 750
                    }"
                    x-text="message.length + '/1000'" class="text-xs font-light">
                    0/1000
                </span>
            </div>
            <div class="flex flex-row-reverse gap-3 items-center pr-4">
                <button type="submit" wire:loading.class='bg-blue-600' wire:target='addReply({{ $comment->id }})'
                    class="bg-blue-500 relative text-white px-4 py-2 w-20 h-8 rounded hover:bg-blue-600 transition-all text-xs font-medium">
                    <span wire:loading wire:target='addReply({{ $comment->id }})'
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <x-icons.spinner size="20" />
                    </span>
                    <span wire:loading.remove wire:target='addReply({{ $comment->id }})'>
                        Yanıtla
                    </span>
                </button>
                <button type="button" x-on:click="replyForm = false"
                    class="bg-gray-100 relative w-20 h-8 text-gray-500 px-4 py-2 rounded hover:bg-gray-200 transition-all text-xs font-medium">
                    <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        Vazgeç
                    </span>
                </button>
            </div>
        </div>
    </div>
</form>
