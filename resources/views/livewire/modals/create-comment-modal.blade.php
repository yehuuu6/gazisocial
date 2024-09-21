<div x-cloak x-show="addCommentModal" x-transition.opacity.duration.250ms role="dialog" aria-modal="true"
    x-on:comment-created.window="addCommentModal = false"
    class="fixed inset-0 bg-gray-500 bg-opacity-50 flex md:items-center items-end
    justify-center h-full z-50">
    <div x-cloak x-show="addCommentModal" x-transition
        class="rounded-lg w-full md:w-3/4 lg:w-1/3 overflow-hidden bg-gray-50 mx-5 md:mx-0 md:mb-0 mb-5"
        @click.away="addCommentModal = false">
        <form wire:submit="createComment" class="bg-white" enctype="multipart/form-data">
            @csrf
            <h3 class="text-xl py-4 px-6 text-gray-700 bg-white font-medium">Yorum Yap</h3>
            <x-seperator />
            <textarea wire:model='content' id="comment-area" spellcheck="false" maxlength="1000" required
                placeholder="Düşüncelerinizi paylaşın..." rows="8" class="w-full outline-none resize-none py-4 px-6"></textarea>
            <x-seperator />
            <div class="p-6 flex items-center justify-between">
                <div :class="{
                    'text-red-500': $wire.content.length >= 1000,
                    'text-yellow-500': $wire.content.length >= 750 && $wire.content.length < 1000,
                    'text-gray-500': $wire.content.length < 750
                }"
                    class="text-sm">
                    <span x-text="$wire.content.length">0</span>/1000 karakter
                </div>
                <div class="flex items-center gap-2 flex-row-reverse">
                    <button type="submit" wire:loading.attr="disabled" wire:target="createComment"
                        wire:loading.class='animate-pulse'
                        class="font-medium px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                        Gönder
                    </button>
                    <button @click="addCommentModal = false" type="button"
                        class="px-4 py-2 font-medium text-sm text-red-500 rounded hover:bg-red-100">
                        İptal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
