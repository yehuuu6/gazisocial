<div class="flex items-center flex-col pt-16 p-6">
    <a href="/" class="h-20 mb-6 hover:opacity-90">
        <img src="{{ asset('\logos/GS_LOGO_DEFAULT.png') }}" alt="Gazi Social" class="object-contain h-full w-full">
    </a>
    <div class="bg-slate-50 border border-slate-200 px-8 pt-6 pb-8 mb-4 rounded-lg max-w-md w-full">
        <form wire:submit="sendPasswordResetLink">
            @csrf
            <div class="flex flex-col gap-0.5 items-start mb-4">
                <label class="block text-gray-700 text-sm font-normal mb-2" for="email">
                    E-posta
                </label>
                <input placeholder="Hesabınıza kayıtlı e-posta adresinizi girin" maxlength="255"
                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="email" type="email" name="email" wire:model="email" autocomplete="mail" required>
            </div>
            <button wire:loading.class="bg-gray-200 cursor-not-allowed"
                data-sitekey="{{ config('services.recaptcha.key') }}" data-callback='onSubmit' data-action='submit'
                wire:loading.class.remove = "bg-primary hover:bg-opacity-100" wire:loading.attr="disabled"
                class="bg-primary text-sm md:text-base g-recaptcha flex items-center h-[40px] gap-1 overflow-hidden justify-center bg-opacity-90 hover:bg-opacity-100 text-white font-medium py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                type="button">
                <x-icons.spinner wire:loading size="32" color="#479fff" />
                <span wire:loading.remove>Şifre Sıfırlama Bağlantısı Gönder</span>
            </button>
        </form>
    </div>
    <div class="text-center">
        <p class="text-gray-600 text-sm">Zaten bir hesabınız var mı?
            <a href="{{ route('login') }}"
                class="inline-block align-baseline font-normal text-sm text-blue-600 hover:underline">Giriş
                Yapın</a>
        </p>
        <p class="text-gray-600 text-sm mt-2">Hesabınız yok mu?
            <a href="{{ route('register') }}"
                class="inline-block align-baseline font-normal text-sm text-blue-600 hover:underline">Kayıt
                Olun</a>
        </p>
    </div>
    <ul class="text-xs p-6 mt-4 rounded-lg flex gap-10">
        <li>
            <a href="/" class="text-gray-700 hover:underline">© 2025 Gazi Social</a>
        </li>
    </ul>
    <script>
        function onSubmit(token) {
            @this.set('recaptchaToken', token);
            @this.call('sendPasswordResetLink');
        }
    </script>
</div>
