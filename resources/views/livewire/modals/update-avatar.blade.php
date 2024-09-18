@php
    $user = Auth::user();
    $url = $user->avatar;
    $previewText = 'Dosya seçilmedi.';

    if ($avatar) {
        $url = $avatar->temporaryUrl();
        $previewText = $avatar->getClientOriginalName();
    }
@endphp

<form wire:submit.prevent="updateAvatar" lazy class="rounded-lg shadow-md" enctype="multipart/form-data">
    @csrf
    <div class="flex items-center justify-between">
        <h3 class="text-base md:text-xl py-3 px-5 md:py-4 md:px-6 text-gray-700 font-medium flex-grow">Profil
            fotoğrafınızı
            güncelleyin</h3>
        <button type="button" wire:click="removeAvatar" wire:loading.attr="disabled" wire:loading.class="animate-pulse"
            class="font-medium px-4 mr-5 md:mr-6 flex items-center justify-center outline-none py-2 text-sm text-red-500 bg-red-50 rounded hover:bg-red-100">
            Fotoğrafı Kaldır
        </button>
    </div>
    <x-seperator />
    <div class="px-6 py-4 flex flex-col items-center justify-center">
        <img id="imagePreview" class="mb-4 size-24 md:size-32 object-cover rounded-full" src="{{ $url }}"
            alt="Image Preview">
        <label wire:loading.class='animate-pulse cursor-not-allowed' wire:loading.class.remove='cursor-pointer'
            wire:target="avatar" wire:loading.attr="disabled"
            class="hover:bg-blue-200 mb-2 py-2 px-4 rounded-full border-0 text-xs md:text-sm font-semibold bg-blue-100 text-blue-500 hover:text-blue-700 cursor-pointer"
            for="imageInput">
            <span wire:loading.remove wire:target=avatar>Dosya Seç</span>
            <span wire:loading wire:target=avatar>Yükleniyor...</span>
        </label>
        <input wire:model="avatar" type="file" id="imageInput" hidden required accept="image/*">
        <span id="imageName" class="text-gray-500 text-sm md:text-base font-normal">{{ $previewText }}</span>
    </div>
    <x-seperator />
    <div class="bg-gray-50 p-4 sm:p-6 gap-2 flex items-center justify-end">
        <button wire:click="$dispatch('closeModal')" type="button"
            class="px-4 py-2 font-medium text-sm text-red-500 rounded-md outline-none hover:bg-red-100">
            Kapat
        </button>
        <button type="submit" wire:loading.class='animate-pulse' wire:loading.attr="disabled"
            wire:target="updateAvatar"
            class="font-medium px-4 flex items-center justify-center outline-none py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
            Kaydet
        </button>
    </div>
</form>
