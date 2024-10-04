<x-modals.modal-wrapper x-show="deleteAccountModal" x-on:poll-created.window="deleteAccountModal = false">
    <x-modals.modal-inner-wrapper x-show="deleteAccountModal" @click.away="deleteAccountModal = false">
        <form wire:submit="deleteAccount" class="rounded-lg bg-white">
            @csrf
            <h3 class="px-6 py-4 text-xl font-medium text-gray-700">Hesabınızı silmek istediğinize emin misiniz?</h3>
            <x-seperator />
            <div class="flex flex-col gap-4 px-6 py-3">
                <div class="flex flex-col gap-0.5">
                    <label for="delete-email" class="block text-sm font-medium text-gray-700">E-posta</label>
                    <input wire:model="email" type="email" id="delete-email" name="delete-email"
                        placeholder="Hesabınızın e-posta adresini girin" required
                        class="mt-1.5 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        autocomplete="off" />
                </div>
                <div class="flex flex-col gap-0.5">
                    <label for="delete-password" class="block text-sm font-medium text-gray-700">Şifre</label>
                    <input wire:model="password" type="password" id="delete-password" name="delete-password"
                        placeholder="Hesabınızın şifresini girin" required
                        class="mt-1.5 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        autocomplete="off" />
                </div>
                <div class="flex flex-col gap-0.5">
                    <label for="confirm" class="block text-sm font-medium text-gray-700">
                        Onaylamak için "DELETE" yazın
                    </label>
                    <input wire:model="confirm" type="text" id="confirm" name="confirm" placeholder="DELETE"
                        required
                        class="mt-1.5 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        autocomplete="off" />
                </div>
            </div>
            <x-seperator />
            <div class="flex items-center justify-end gap-2 bg-gray-50 p-6">
                <button type="button" @click="deleteAccountModal = false"
                    class="rounded px-4 py-2 text-green-600 outline-none hover:bg-green-100">
                    Vazgeç
                </button>
                <button type="submit"
                    class="rounded bg-red-500 px-6 py-2 font-medium text-white outline-none hover:bg-red-600">
                    Onayla
                </button>
            </div>
        </form>

    </x-modals.modal-inner-wrapper>
</x-modals.modal-wrapper>
