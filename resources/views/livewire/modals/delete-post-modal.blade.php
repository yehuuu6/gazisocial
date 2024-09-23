<x-modals.modal-wrapper x-show="deletePostModal" x-on:post-deleted.window="deletePostModal = false"
    x-on:delete-post-modal-open.window="$wire.set('postId', postId)">
    <x-modals.modal-inner-wrapper x-show="deletePostModal" @click.away="deletePostModal = false">
        <form wire:submit="deletePost" enctype="multipart/form-data">
            @csrf
            <h3 class="text-xl py-4 px-6 text-gray-700 bg-white font-medium">Konuyu Kaldır</h3>
            <x-seperator />
            <input type="hidden" id="post-id" name="post-id" wire:model="postId">
            <div class="bg-white py-4 px-6">
                <p>Konuyu silmek istediğinize emin misiniz?</p>
                <strong class="text-red-500">Bu işlem geri alınamaz!</strong>
            </div>
            <x-seperator />
            <div class="bg-gray-50 p-6 flex items-center justify-end">
                <div class="flex items-center gap-2 flex-row-reverse">
                    <button type="submit" wire:loading.attr="disabled" wire:target="deletePost"
                        wire:loading.class='animate-pulse'
                        class="font-medium px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                        Evet, Sil
                    </button>
                    <button @click="deletePostModal = false" type="button"
                        class="px-4 py-2 font-medium text-sm text-red-500 rounded hover:bg-red-100">
                        İptal
                    </button>
                </div>
            </div>
        </form>
    </x-modals.modal-inner-wrapper>
</x-modals.modal-wrapper>
