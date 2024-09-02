<form id="add-comment-modal" wire:submit="createComment" class="rounded-lg shadow-md">
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
        <span id="character-counter" class="text-sm text-gray-500">
            0/1000 karakter
        </span>
        <div class="flex items-center gap-2 flex-row-reverse">
            <button type="submit"
                class="font-medium px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                Gönder
            </button>
            <button wire:click="$dispatch('closeModal')" type="button"
                class="px-4 py-2 font-medium text-sm text-red-500 rounded hover:bg-red-100">
                İptal
            </button>
        </div>
</form>
@script
    <script>
        document.getElementById('comment-area').addEventListener('input', function() {
            const commentArea = document.getElementById('comment-area');
            const commentLength = commentArea.value.length;
            const commentLengthElement = document.querySelector('#character-counter');
            commentLengthElement.textContent = `${commentLength}/1000 karakter`;
            if (commentLength >= 1000) {
                commentLengthElement.classList.add('text-red-500');
                commentLengthElement.classList.remove('text-yellow-500', 'text-gray-500');
            } else if (commentLength >= 750) {
                commentLengthElement.classList.add('text-yellow-500');
                commentLengthElement.classList.remove('text-red-500', 'text-gray-500');
            } else {
                commentLengthElement.classList.add('text-gray-500');
                commentLengthElement.classList.remove('text-red-500', 'text-yellow-500');
            }
        });
    </script>
@endscript
