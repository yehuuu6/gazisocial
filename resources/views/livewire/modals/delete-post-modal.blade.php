<form wire:submit="deletePost" class="rounded-lg shadow-md">
    @csrf
    <h3 class="text-xl py-4 px-6 text-gray-700 font-medium">Konuyu silmek istediğinize emin misiniz?</h3>
    <x-seperator />
    <p class="px-6 py-4 text-red-400 text-sm font-medium">Bu işlem geri alınamaz.</p>
    <x-seperator />
    <div class="bg-gray-50 p-4 gap-2 flex items-center justify-end">
        <button wire:click="$dispatch('closeModal')" type="button"
            class="px-4 py-2 font-medium text-sm text-red-500 rounded-md hover:bg-red-100">
            İptal
        </button>
        <button type="submit" wire:loading.class="animate-pulse"
            class="font-medium px-4 flex items-center justify-center py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
            Sil
        </button>
</form>
