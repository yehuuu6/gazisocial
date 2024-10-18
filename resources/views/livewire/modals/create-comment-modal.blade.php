<x-modals.modal-wrapper x-show="addCommentModal" x-on:comment-created.window="addCommentModal = false">
    <x-modals.modal-inner-wrapper x-show="addCommentModal" @click.away="addCommentModal = false" x-trap="addCommentModal">
        <form wire:submit="createComment" class="bg-white">
            @csrf
            <h3 class="bg-white px-6 py-4 text-xl font-medium text-gray-700">Yorum Yap</h3>
            <x-seperator />
            <textarea wire:model='content' id="comment-area" spellcheck="false" maxlength="1000" required
                placeholder="Düşüncelerinizi paylaşın..." rows="8" class="w-full resize-none px-6 py-4 outline-none"></textarea>
            <x-seperator />
            <div class="flex items-center justify-between bg-gray-50 p-6">
                <div :class="{
                    'text-red-500': $wire.content.length >= 1000,
                    'text-yellow-500': $wire.content.length >= 750 && $wire.content.length < 1000,
                    'text-gray-500': $wire.content.length < 750
                }"
                    class="text-sm">
                    <span x-text="$wire.content.length">0</span>/1000 karakter
                </div>
                <div class="flex flex-row-reverse items-center gap-2">
                    <button type="submit" wire:loading.attr="disabled" wire:target="createComment"
                        wire:loading.class='animate-pulse'
                        class="rounded bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
                        Gönder
                    </button>
                    <button @click="addCommentModal = false" type="button"
                        class="rounded px-4 py-2 text-sm font-medium text-red-500 hover:bg-red-100">
                        İptal
                    </button>
                </div>
            </div>
        </form>
    </x-modals.modal-inner-wrapper>
</x-modals.modal-wrapper>
