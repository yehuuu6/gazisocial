<x-modal {{ $attributes }}>
    <x-slot name="title">
        <h1 class="text-lg font-semibold p-4 text-gray-700">Kayıt Ol</h1>
    </x-slot>
    <x-slot name="body">
        <div class="p-6">
            <div class="h-12 mb-4">
                <img src="{{ asset('logos/GS_LOGO_DEFAULT.png') }}" alt="Gazi Social" class="object-contain h-full w-full">
            </div>
            <h3 class="font-medium text-gray-700 text-base mb-3 text-center">
                Gazi Social topluluğuna hoş geldiniz. <span x-text='message'></span> üye olmanız gerekmektedir.
            </h3>
            <p class="text-sm text-gray-600 font-normal mb-3 text-center">
                Kayıt olarak, <x-link href="{{ route('terms') }}" class="text-blue-500">kullanım koşulları</x-link> ve
                <x-link href="{{ route('privacy') }}" class="text-blue-500">gizlilik politikası</x-link> şartlarını
                kabul etmiş olursunuz.
            </p>
            <div class="flex flex-col items-center gap-3">
                <button type="button" wire:click="redirectAuth('register')"
                    class="rounded-full text-center w-2/3 bg-primary px-4 py-2 border border-primary text-sm font-medium text-white hover:bg-opacity-90">
                    Kayıt Ol
                </button>
                <span class="text-xs text-gray-500 font-normal text-center">Zaten üye misin?</span>
                <button type="button" wire:click="redirectAuth('login')"
                    class="rounded-full text-center w-2/3 px-4 py-2 text-sm font-medium text-primary hover:text-white hover:bg-opacity-90 hover:bg-primary border border-primary">
                    Giriş Yap
                </button>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        <div class="bg-gray-50 p-6 flex items-center justify-end">
            <button x-on:click="registerModal = false" type="button"
                class="rounded bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">
                Kapat
            </button>
        </div>
    </x-slot>
</x-modal>
