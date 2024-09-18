<form id="add-comment-modal" wire:submit="createComment" class="rounded-lg shadow-md" enctype="multipart/form-data">
    @csrf
    <h3 class="text-xl py-4 px-6 text-gray-700 font-medium">Yorum Yap</h3>
    <x-seperator />
    @if ($errors->any())
        <div class="bg-red-100 border border-red-200 text-red-400 font-medium px-2 py-3 mx-6 mt-4 rounded relative"
            role="alert">
            <ul class="px-1 space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="break-words">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <textarea wire:model='content' id="comment-area" spellcheck="false" maxlength="1000"
        placeholder="Düşüncelerinizi paylaşın..." rows="8" class="w-full outline-none resize-none py-4 px-6"></textarea>
    <x-seperator />
    <div class="bg-gray-50 p-6 flex items-center justify-between">
        <p :class="{
            'text-red-500': $wire.content.length >= 1000,
            'text-yellow-500': $wire.content.length >= 750 && $wire.content.length < 1000,
            'text-gray-500': $wire.content.length < 750
        }"
            class="text-sm">
            <span x-text="$wire.content.length">0</span>/1000 karakter
        </p>
        <div class="flex items-center gap-2 flex-row-reverse">
            <button type="submit" wire:loading.attr="disabled" wire:target="createComment"
                wire:loading.class='animate-pulse'
                class="font-medium px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                Gönder
            </button>
            <button wire:click="$dispatch('closeModal')" type="button"
                class="px-4 py-2 font-medium text-sm text-red-500 rounded hover:bg-red-100">
                İptal
            </button>
        </div>
</form>
