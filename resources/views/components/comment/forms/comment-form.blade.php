<div>
    <form wire:submit='addComment()' x-data="{ message: '' }" id="comment-form">
        <div class="rounded-3xl border border-gray-300 bg-white py-2.5 px-4 pr-0 mb-4 overflow-hidden">
            <textarea x-model="message" spellcheck="false" class="resize-y text-sm text-gray-600 w-full outline-none pt-1"
                wire:model="content" id="content" name="content" rows="2" maxlength="1000" required x-trap="commentForm"></textarea>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-1 flex-wrap">
                    <button x-on:click="gifSelector = !gifSelector" x-ref="gifOpener"
                        class="text-gray-600 p-2 hover:bg-gray-100 rounded-full" type="button">
                        <x-icons.gif size="20" />
                    </button>
                    <div x-cloak x-show="gifSelector" x-anchor.bottom-start="$refs.gifOpener"
                        x-on:click.away="gifSelector = false"
                        class="w-[250px] md:w-[500px] max-h-[450px] p-2 border border-gray-200 rounded-lg shadow-md bg-white z-20">
                        <livewire:giphy-search :key="'search-gif'" />
                    </div>
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
                <div class="flex flex-row-reverse gap-1 md:gap-3 items-center pr-4">
                    <button type="submit" wire:loading.class='bg-blue-600' wire:target='addComment'
                        class="bg-blue-500 relative text-white px-3 font-normal h-6 md:px-4 py-2 w-20 md:h-8 rounded hover:bg-blue-600 transition-all text-xs md:font-medium">
                        <span wire:loading wire:target='addComment'
                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <x-icons.spinner size="20" />
                        </span>
                        <span wire:loading.remove wire:target='addComment'
                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            Gönder
                        </span>
                    </button>
                    <button type="button" x-on:click="commentForm = false"
                        class="bg-gray-100 relative px-3 font-normal w-16 h-6 md:px-4 py-2 md:w-20 md:h-8 text-gray-500 rounded hover:bg-gray-200 transition-all text-xs md:font-medium">
                        <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            Vazgeç
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
