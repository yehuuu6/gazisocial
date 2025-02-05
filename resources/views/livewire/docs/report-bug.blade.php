<div x-data="{ exampleBugModal: false }">
    <form wire:submit="reportBug" class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
        <h1 class="text-3xl font-bold text-gray-900 mx-6 mt-6">Hata Bildir (Report a Bug)</h1>
        <p class="text-gray-600 mx-6 mt-2">
            Bir hata ile mi karşılaştınız? Lütfen aşağıdaki formu doldurarak bize bildirin. (Örnek hata bildirimine
            bakmayı
            unutmayın!)
        </p>
        <div class="m-6">
            <div class="flex flex-col gap-1">
                <label for="title" class="text-sm font-medium text-gray-700">Başlık</label>
                <input wire:model="title" type="text" id="title" name="title" required
                    class="outline-none border border-gray-300 rounded-md p-2 text-sm text-gray-700"
                    placeholder="Hata başlığı">
            </div>
            <div class="flex flex-col gap-1 mt-4">
                <label for="description" class="text-sm font-medium text-gray-700">Açıklama</label>
                <textarea wire:model="description" id="description" name="description" required
                    class="outline-none border border-gray-300 rounded-md p-2 text-sm text-gray-700" placeholder="Hata açıklaması"
                    rows="4"></textarea>
            </div>
        </div>
        <div class="mx-6 mb-6 w-fit">
            <x-alerts.warning>
                Laravel (Livewire) teknik bilginiz var ise, doğrudan <a
                    href="https://github.com/yehuuu6/gazisocial/issues" target="_blank" class="hover:underline">GitHub
                    Issues</a> sayfasına hata bildirimi yapabilirsiniz.
            </x-alerts.warning>
        </div>
        <x-seperator />
        <div class="bg-gray-50 p-6 flex justify-end items-center gap-3">
            <button type="button" x-on:click="exampleBugModal = true"
                class="outline:none rounded border border-green-500 bg-transparent px-6 py-2 font-medium text-green-500 hover:bg-green-500 hover:text-white">
                Örnek
            </button>
            <button type="submit"
                class="w-[95px] px-6 py-2 bg-blue-500 text-white font-medium rounded border border-blue-500">
                <span class="flex items-center justify-center" wire:loading.remove wire:target="reportBug">
                    Bildir
                </span>
                <span class="flex items-center justify-center" wire:loading.flex wire:target="reportBug">
                    <x-icons.spinner size='24' color='white' />
                </span>
            </button>
        </div>
    </form>
    <x-modal wire:modal='exampleBugModal'>
        <x-slot name="title">
            <h3 class="px-6 py-4 text-xl font-medium text-gray-700">Örnek Hata Bildirimi</h3>
        </x-slot>
        <x-slot name="body">
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
        </x-slot>
        <x-slot name="footer">
            <div class="bg-gray-50 p-6 flex items-center justify-end">
                <button x-on:click="exampleBugModal = false" type="button"
                    class="rounded bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
                    Kapat
                </button>
            </div>
        </x-slot>
    </x-modal>
</div>
