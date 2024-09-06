<form wire:submit="updateAvatar" class="rounded-lg shadow-md">
    @csrf
    <h3 class="text-xl py-4 px-6 text-gray-700 font-medium">Profil fotoğrafınızı güncelleyin</h3>
    <x-seperator />
    <div class="px-6 py-4">
        <img id="imagePreview" class="mb-4 w-32 h-32 object-cover rounded-full" src="{{ Auth::user()->avatar }}"
            alt="Image Preview">
        <input type="file" id="imageInput"
            class="block w-full text-sm text-gray-500
            file:mr-4 file:py-2 file:px-4
            file:rounded-full file:border-0
            file:text-sm file:font-semibold
            file:bg-violet-50 file:text-violet-700
            hover:file:bg-violet-100
            outline-none
        "
            accept="image/*">
    </div>
    <x-seperator />
    <div class="bg-gray-50 p-6 gap-2 flex items-center justify-end">
        <button wire:click="$dispatch('closeModal')" type="button"
            class="px-4 py-2 font-medium text-sm text-red-500 rounded-md hover:bg-red-100">
            Kapat
        </button>
        <button type="submit" wire:loading.class="animate-pulse"
            class="font-medium px-4 flex items-center justify-center py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
            Kaydet
        </button>
</form>
@script
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('imagePreview');
                    img.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endscript
