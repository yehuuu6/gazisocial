<div wire:show="showRegisterModal" wire:transition.opacity x-cloak
    class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 grid place-items-center transition-all duration-300 ease-in-out">
    <div wire:show="showRegisterModal" wire:transition.scale
        class="rounded-xl shadow-lg bg-white relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full h-fit">
        <div class="bg-gradient-to-r from-primary to-blue-400 text-white rounded-t-xl">
            <h3 class="px-6 py-4 text-lg font-semibold text-white flex items-center gap-2">
                <x-tabler-user-plus class="size-6" />
                Gazi Social'a Katıl
            </h3>
        </div>
        <div class="p-6">
            <div class="h-16 mb-4 flex justify-center items-center">
                <img src="{{ asset('logos/GS_LOGO_DEFAULT.png') }}" alt="Gazi Social" class="object-contain h-full">
            </div>
            <h3 class="font-medium text-gray-800 text-base mb-4 text-center">
                Gazi Social topluluğuna hoş geldiniz. Devam etmek için üye olmanız gerekmektedir.
            </h3>
            <p class="text-sm text-gray-600 font-normal mb-5 text-center">
                Kayıt olarak, <x-link href="{{ route('terms') }}"
                    class="text-blue-400 transition-colors duration-200">kullanım koşulları</x-link>
                ve
                <x-link href="{{ route('privacy') }}" class="text-blue-400 transition-colors duration-200">gizlilik
                    politikası</x-link> şartlarını
                kabul etmiş olursunuz.
            </p>
            <div class="flex flex-col items-center gap-4">
                <a href="{{ route('register') }}"
                    class="rounded-md w-2/3 flex items-center justify-center gap-2 bg-primary px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-950 transition-all duration-200">
                    <x-tabler-user-plus class="size-4" />
                    Kayıt Ol
                </a>
                <div class="flex items-center gap-3 my-1">
                    <span class="h-px bg-gray-300 flex-1"></span>
                    <span class="text-xs text-gray-500 font-medium">Zaten üye misin?</span>
                    <span class="h-px bg-gray-300 flex-1"></span>
                </div>
                <a href="{{ route('login') }}"
                    class="rounded-md w-2/3 flex items-center gap-2 justify-center border border-primary px-4 py-2.5 text-sm font-medium text-primary hover:bg-primary hover:bg-opacity-5 transition-colors duration-200">
                    <x-tabler-user class="size-4" />
                    Giriş Yap
                </a>
            </div>
        </div>
        <div>
            <div class="bg-gray-50 p-5 flex items-center justify-end border-t border-gray-100 rounded-b-xl">
                <button x-on:click="$wire.showRegisterModal = false" type="button"
                    class="rounded-md px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 transition-colors duration-200">
                    Kapat
                </button>
            </div>
        </div>
    </div>
</div>
