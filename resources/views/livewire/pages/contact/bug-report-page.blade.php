<form wire:submit="reportBug" x-data="{ exampleBugModal: false }"
    class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
    <livewire:modals.example-bug-report-modal />
    <h1 class="text-3xl font-bold text-gray-900 mx-6 mt-6">Hata Bildir (Report a Bug)</h1>
    <p class="text-gray-600 mx-6 mt-2">
        Bir hata ile mi karşılaştınız? Lütfen aşağıdaki formu doldurarak bize bildirin. (Örnek hata bildirimine bakmayı
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
    <div
        class="mx-6 mb-6 py-2 px-4 inline-flex gap-2.5 items-center rounded-md border border-orange-200 bg-orange-50 text-orange-400 text-sm font-normal self-start">
        <x-icons.info color="orange" size="18" />
        <span>
            Laravel (Livewire) teknik bilginiz var ise, doğrudan <a href="https://github.com/yehuuu6/gazisocial/issues"
                target="_blank" class="hover:underline">GitHub Issues</a> sayfasına hata bildirimi yapabilirsiniz.
        </span>
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
