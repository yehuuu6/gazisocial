<div>
    <form wire:submit="addReply({{ $comment->id }})" x-data="{ message: '' }">
        <div class="rounded-3xl border border-gray-300 bg-white py-2.5 px-4 pr-0 my-3 overflow-hidden">
            <textarea x-model="message" spellcheck="false" class="resize-y text-xs md:text-sm text-gray-600 w-full outline-none pt-1"
                wire:model="content" id="content" name="content" rows="2" maxlength="1000" x-trap="$wire.replyForm" required></textarea>
            <div class="flex items-center justify-between flex-wrap">
                <div class="flex items-center gap-1 flex-wrap">
                    @auth
                        <button x-on:click="gifSelector = !gifSelector" x-ref="gifOpener"
                            class="text-gray-600 p-2 hover:bg-gray-100 rounded-full" type="button">
                            <x-icons.gif size="20" />
                        </button>
                        <div x-cloak x-show="gifSelector" x-anchor.bottom-start="$refs.gifOpener"
                            x-on:click.outside="gifSelector = false"
                            class="w-[250px] md:w-[500px] max-h-[450px] p-2 border border-gray-200 rounded-lg shadow-md bg-white z-20">
                            <livewire:giphy-search lazy :key="'search-gif-{{ $comment->id }}'" />
                        </div>
                    @endauth
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
                <div
                    class="flex flex-row-reverse gap-1 md:gap-3 items-center justify-start md:justify-end pr-4 flex-wrap">
                    <button type="submit" wire:loading.class='bg-blue-600' wire:target='addReply({{ $comment->id }})'
                        class="bg-blue-500 relative text-white px-3 font-normal w-16 h-6 md:px-4 py-2 md:w-20 md:h-8 rounded hover:bg-blue-600 transition-all text-xs md:font-medium">
                        <span wire:loading wire:target='addReply({{ $comment->id }})'
                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <x-icons.spinner size="20" />
                        </span>
                        <span wire:loading.remove wire:target='addReply({{ $comment->id }})'
                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs">
                            Yanıtla
                        </span>
                    </button>
                    <button type="button" x-on:click="$wire.replyForm = false"
                        class="bg-gray-100 relative px-3 font-normal w-16 h-6 md:px-4 py-2 md:w-20 md:h-8 text-gray-500 rounded hover:bg-gray-200 transition-all text-xs md:font-medium">
                        <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs">
                            Vazgeç
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>
