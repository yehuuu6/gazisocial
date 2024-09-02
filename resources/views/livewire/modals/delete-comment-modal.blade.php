<form wire:submit="deleteComment" class="rounded-lg shadow-md">
    @csrf
    <h3 class="text-xl py-4 px-6 text-gray-700 font-medium">Yorumu Silmek İstediğinize Emin Misiniz?</h3>
    <x-seperator />
    <article class="px-6 py-2 text-gray-600">
        <p>{{ $comment->content }}</p>
    </article>
    <p class="px-6 py-4 text-red-400 text-sm font-medium">Bu işlem geri alınamaz.</p>
    <x-seperator />
    <div class="bg-gray-50 p-6 gap-2 flex items-center justify-end">
        <button wire:click="$dispatch('closeModal')" type="button"
            class="px-4 py-2 font-medium text-sm text-red-500 rounded-md hover:bg-red-100">
            İptal
        </button>
        <button type="submit"
            class="font-medium h-[40px] px-4 flex items-center justify-center py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
            <x-icons.spinner wire:loading.remove size="26" color="#479fff" />
            <span wire:loading>Sil</span>
        </button>
</form>
