<x-modals.modal-wrapper x-show="deletePollModal" x-on:poll-deleted.window="deletePollModal = false"
    x-on:delete-poll-modal-open.window="$wire.set('pollId', pollId)">
    <x-modals.modal-inner-wrapper x-show="deletePollModal" @click.away="deletePollModal = false">
        <form wire:submit="deletePoll">
            @csrf
            <h3 class="text-xl py-4 px-6 text-gray-700 bg-white font-medium">Anketi Kaldır</h3>
            <x-seperator />
            <input type="hidden" id="poll-id" name="poll-id" wire:model="pollId">
            <div class="bg-white py-4 px-6">
                <p>Anketi kaldırmak istediğinize emin misiniz?</p>
                <strong class="text-red-500">Bu işlem geri alınamaz!</strong>
                <p>Anketi sildiğiniz zaman verilen tüm oylar da silinecektir.</p>
            </div>
            <x-seperator />
            <div class="bg-gray-50 p-6 flex items-center justify-end">
                <div class="flex items-center gap-2 flex-row-reverse">
                    <button type="submit" wire:loading.attr="disabled" wire:target="deletePoll"
                        wire:loading.class='animate-pulse'
                        class="font-medium px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                        Evet, kaldır
                    </button>
                    <button @click="deletePollModal = false" type="button"
                        class="px-4 py-2 font-medium text-sm text-red-500 rounded hover:bg-red-100">
                        İptal
                    </button>
                </div>
            </div>
        </form>
    </x-modals.modal-inner-wrapper>
</x-modals.modal-wrapper>
