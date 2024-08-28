<div id="add-comment-modal"
    class="absolute flex animate-fadeIn inset-0 items-center justify-center bg-gray-500 bg-opacity-35 transition-opacity">
    <form
        class="px-5 animate-showUp py-5 relative rounded-lg border border-gray-300 shadow-md bg-white w-1/2 max-w-[500px]">
        @csrf
        <span class="absolute top-2 p-1 right-2 text-lg opacity-75 text-red-500 hover:opacity-100 cursor-pointer">
            <x-icons.close />
        </span>
        <h3 class="text-xl font-medium">Yorum Yap</h3>
        <textarea id="comment-area" maxlength="500" placeholder="Yorumunuzu buraya yazın..." rows="4"
            class="w-full outline-none resize-none border border-gray-400 p-3 rounded-md mt-7"></textarea>
        <div class="mt-4 mb-3 flex items-center justify-between">
            <span id="character-counter" class="text-sm text-gray-500">
                0/500 karakter
            </span>
            <div class="flex items-center gap-2 flex-row-reverse">
                <button type="button"
                    class="font-medium px-4 py-2 text-sm text-white bg-blue-500 rounded-md hover:bg-blue-600">
                    Gönder
                </button>
                <button type="button" class="px-4 py-2 font-medium text-sm text-gray-600 rounded-md hover:bg-gray-200">
                    İptal
                </button>
            </div>
    </form>
</div>

@script
    <script>
        document.addEventListener('livewire:initialized', () => {
            document.getElementById('comment-area').addEventListener('input', function() {
                const commentArea = document.getElementById('comment-area');
                const commentLength = commentArea.value.length;
                const commentLengthElement = document.querySelector('#character-counter');
                commentLengthElement.textContent = `${commentLength}/500 karakter`;
                if (commentLength >= 500) {
                    commentLengthElement.classList.add('text-red-500');
                    commentLengthElement.classList.remove('text-yellow-500', 'text-gray-500');
                } else if (commentLength >= 400) {
                    commentLengthElement.classList.add('text-yellow-500');
                    commentLengthElement.classList.remove('text-red-500', 'text-gray-500');
                } else {
                    commentLengthElement.classList.add('text-gray-500');
                    commentLengthElement.classList.remove('text-red-500', 'text-yellow-500');
                }
            });
        })
    </script>
@endscript
