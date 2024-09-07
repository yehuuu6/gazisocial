@php

    $url = Auth::user()->avatar;

    $previewText = 'Dosya seçilmedi.';

    if ($avatar) {
        $url = $avatar->temporaryUrl();
        $previewText = $avatar->getClientOriginalName();
    }
@endphp

<form wire:submit="save" class="rounded-lg shadow-md" enctype="multipart/form-data">
    @csrf
    <h3 class="text-xl py-4 px-6 text-gray-700 font-medium">Profil fotoğrafınızı güncelleyin</h3>
    <x-seperator />
    <div class="px-6 py-4 flex flex-col items-center justify-center">
        <img id="imagePreview" class="mb-4 size-32 object-cover rounded-full" src="{{ $url }}" alt="Image Preview">
        <label
            class="hover:bg-violet-100 mb-2 py-2 px-4 rounded-full border-0 text-sm 
            font-semibold bg-violet-50 text-violet-700 cursor-pointer"
            for="imageInput">Dosya Seç</label>
        <input wire:model="avatar" type="file" id="imageInput" class="hidden" accept="image/*">
        <span id="imageName" class="text-gray-500 font-normal">{{ $previewText }}</span>
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
