<form wire:submit="sendMessage" class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
    <h1 class="text-3xl font-bold text-gray-900 mx-6 mt-6">Bizimle İletişime Geç (Contact Us)</h1>
    <p class="text-gray-600 mx-6 mt-2">
        Forum hakkında geri bildirimde bulunmak, şikayet, istek ve önerilerinizi iletmek için aşağıdaki formu
        doldurabilirsiniz.
    </p>
    <div class="m-6">
        <div class="flex flex-col gap-1">
            <label for="name" class="text-sm font-medium text-gray-700">Adınız</label>
            <input wire:model="name" type="text" id="name" name="name" required
                class="outline-none border border-gray-300 rounded-md p-2 text-sm text-gray-700"
                placeholder="Adınız ve soyadınız">
        </div>
        <div class="flex flex-col gap-1 mt-4">
            <label for="email" class="text-sm font-medium text-gray-700">E-Posta Adresiniz</label>
            <input wire:model="email" type="email" id="email" name="email" required
                class="outline-none border border-gray-300 rounded-md p-2 text-sm text-gray-700"
                placeholder="E-Posta Adresiniz">
        </div>
        <div class="flex flex-col gap-1 mt-4">
            <label for="message" class="text-sm font-medium text-gray-700">Mesajınız</label>
            <textarea wire:model="message" id="message" name="message" required
                class="outline-none border border-gray-300 rounded-md p-2 text-sm text-gray-700" placeholder="Mesajınızı yazın"
                rows="4"></textarea>
        </div>
    </div>
    <div class="px-6 mb-6 w-fit">
        <x-alerts.warning>
            Gönderilen mesajlar, yalnızca forum yöneticileri tarafından incelenir ve en kısa sürede geri dönüş yapılır.
        </x-alerts.warning>
    </div>
    <x-seperator />
    <div class="bg-gray-50 p-6 flex justify-end items-center gap-3">
        <button type="submit"
            class="w-[95px] px-6 py-2 bg-blue-500 text-white font-medium rounded border border-blue-500">
            <span class="flex items-center justify-center" wire:loading.remove wire:target="sendMessage">
                Gönder
            </span>
            <span class="flex items-center justify-center" wire:loading.flex wire:target="sendMessage">
                <x-icons.spinner size='24' color='white' />
            </span>
        </button>
    </div>
</form>
