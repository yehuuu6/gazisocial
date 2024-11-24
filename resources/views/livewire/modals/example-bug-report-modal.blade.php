<x-modals.modal-wrapper x-show="exampleBugModal">
    <x-modals.modal-inner-wrapper x-show="exampleBugModal" x-on:click.away="exampleBugModal = false"
        x-trap="exampleBugModal">
        <div class="bg-white">
            <h3 class="bg-white px-6 py-4 text-xl font-medium text-gray-700">Örnek Hata Bildirimi</h3>
            <x-seperator />
            <div class="flex flex-col gap-1 mx-6 mt-6">
                <h3 class="text-sm font-medium text-gray-700">Başlık</h3>
                <p class="border border-gray-300 rounded-md p-2 text-sm text-gray-700">
                    Hatayı kısaca açıklayınız...
                </p>
            </div>
            <div class="flex flex-col gap-1 mt-6 mx-6 mb-6">
                <h3 class="text-sm font-medium text-gray-700">Açıklama</h3>
                <div class="border border-gray-300 rounded-md p-2 text-sm text-gray-700 max-h-32 overflow-y-auto">
                    **Tekrar etmek için adımlar**<br>
                    1. Adım<br>
                    2. Adım<br>
                    ...<br>
                    **Beklenen davranış**<br>
                    Şöyle olmalıydı...<br>
                    **Gerçekleşen davranış**<br>
                    Şöyle oldu...<br>
                    **Cihaz**<br>
                    - Tarayıcı: Google Chrome, Brave, Firefox, Safari, Edge vb.<br>
                    - İşletim Sistemi: Windows 11 Pro, macOS Big Sur, Ubuntu 20.04 vb.<br>
                    **Ek bilgiler**<br>
                    - Kısa ve öz vermek istediğiniz ek bilgi.<br>
                </div>
            </div>
            <x-seperator />
            <div class="bg-gray-50 p-6 flex items-center justify-end">
                <button x-on:click="exampleBugModal = false" type="button"
                    class="rounded bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
                    Kapat
                </button>
            </div>
        </div>
    </x-modals.modal-inner-wrapper>
</x-modals.modal-wrapper>
