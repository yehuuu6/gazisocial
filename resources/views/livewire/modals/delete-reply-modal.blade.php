<x-modals.modal-wrapper x-show="deleteReplyModal" x-on:reply-deleted.window="deleteReplyModal = false"
    x-on:delete-reply-modal-open.window="$wire.set('replyId', replyId)">
    <x-modals.modal-inner-wrapper x-show="deleteReplyModal" @click.away="deleteReplyModal = false">
        <form wire:submit="deleteReply" enctype="multipart/form-data">
            @csrf
            <h3 class="bg-white px-6 py-4 text-xl font-medium text-gray-700">Yorumu Kaldır</h3>
            <x-seperator />
            <input type="hidden" id="reply-id" name="reply-id" wire:model="replyId">
            <div class="bg-white px-6 py-4">
                <p>Yanıtınızı silmek istediğinize emin misiniz?</p>
                <strong class="text-red-500">Bu işlem geri alınamaz!</strong>
            </div>
            <x-seperator />
            <div class="flex items-center justify-end bg-gray-50 p-6">
                <div class="flex flex-row-reverse items-center gap-2">
                    <button type="submit" wire:loading.attr="disabled" wire:target="deleteReply"
                        wire:loading.class='animate-pulse'
                        class="rounded bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
                        Evet, Sil
                    </button>
                    <button @click="deleteReplyModal = false" type="button"
                        class="rounded px-4 py-2 text-sm font-medium text-red-500 hover:bg-red-100">
                        İptal
                    </button>
                </div>
            </div>
        </form>
    </x-modals.modal-inner-wrapper>
</x-modals.modal-wrapper>
