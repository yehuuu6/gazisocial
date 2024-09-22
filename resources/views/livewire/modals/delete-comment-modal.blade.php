<x-modal-wrapper x-show="deleteCommentModal" x-on:comment-deleted.window="deleteCommentModal = false"
    x-on:delete-comment-modal-open.window="$wire.set('commentId', commentId)">
    <x-modal-inner-wrapper x-show="deleteCommentModal" @click.away="deleteCommentModal = false">
        <form wire:submit="deleteComment" enctype="multipart/form-data">
            @csrf
            <h3 class="text-xl py-4 px-6 text-gray-700 bg-white font-medium">Yorumu Kaldır</h3>
            <x-seperator />
            <input type="hidden" id="comment-id" name="comment-id" wire:model="commentId">
            <div class="bg-white py-4 px-6">
                <p>Yorumu silmek istediğinize emin misiniz?</p>
                <strong class="text-red-500">Bu işlem geri alınamaz!</strong>
            </div>
            <x-seperator />
            <div class="bg-gray-50 p-6 flex items-center justify-end">
                <div class="flex items-center gap-2 flex-row-reverse">
                    <button type="submit" wire:loading.attr="disabled" wire:target="deleteComment"
                        wire:loading.class='animate-pulse'
                        class="font-medium px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                        Evet, Sil
                    </button>
                    <button @click="deleteCommentModal = false" type="button"
                        class="px-4 py-2 font-medium text-sm text-red-500 rounded hover:bg-red-100">
                        İptal
                    </button>
                </div>
            </div>
        </form>
    </x-modal-inner-wrapper>
</x-modal-wrapper>
