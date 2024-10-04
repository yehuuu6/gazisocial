<div class="flex items-center flex-col mt-6 p-6">
    <div class="flex items-center justify-center flex-col gap-5">
        <a href="/"><img src="{{ asset('gazi-logo.png') }}" alt="" class="w-14 h-14"></a>
        <h3 class="text-center mb-5 text-2xl font-light">Gazi Social Şifre Sıfırlama</h3>
    </div>
    <div class="bg-gray-50 border border-gray-200 px-8 pt-6 pb-8 mb-4 rounded-lg max-w-md w-full">
        <form wire:submit="resetPassword">
            @csrf
            <div class="flex flex-col gap-0.5 items-start">
                <label class="block text-gray-700 text-sm font-normal mb-2" for="email">
                    E-posta
                </label>
                <input placeholder="Hesabınıza kayıtlı e-posta adresinizi girin" maxlength="255"
                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="email" type="email" name="email" wire:model="email" autocomplete="mail" required>
            </div>
            <div class="flex flex-col gap-0.5 items-start mt-2">
                <label class="block text-gray-700 text-sm font-normal mb-2" for="password">
                    Yeni Şifre
                </label>
                <input minlength="8" maxlength="255"
                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="password" type="password" name="password" wire:model="password" required>
            </div>
            <div class="flex flex-col gap-0.5 items-start mt-2">
                <label class="block text-gray-700 text-sm font-normal mb-2" for="password_confirmation">
                    Şifreyi Onayla
                </label>
                <input minlength="8" maxlength="255"
                    class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="password_confirmation" type="password" name="password_confirmation"
                    wire:model="password_confirmation" required>
            </div>
            <button wire:loading.class="bg-gray-200 cursor-not-allowed"
                wire:loading.class.remove = "bg-primary hover:bg-opacity-100" wire:loading.attr="disabled"
                class="bg-primary flex items-center h-[40px] gap-1 overflow-hidden justify-center bg-opacity-90 hover:bg-opacity-100 text-white font-medium py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                type="submit">
                <x-icons.spinner wire:loading size="32" color="#479fff" />
                <span wire:loading.remove>Şifremi Sıfırla</span>
            </button>
        </form>
    </div>
    <div class="text-center">
        <p class="text-gray-600 text-sm">Giriş yapmak için
            <a href="{{ route('login') }}"
                class="inline-block align-baseline font-normal text-sm text-blue-600 hover:underline">tıklayın</a>
        </p>
        <p class="text-gray-600 text-sm mt-2">Ana sayfaya dönmek için
            <a href="{{ route('home') }}"
                class="inline-block align-baseline font-normal text-sm text-blue-600 hover:underline">tıklayın</a>
        </p>
    </div>
    <ul class="text-xs p-6 mt-4 rounded-lg flex gap-10">
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-gray-700 hover:underline">Çıkış Yap</button>
            </form>
        </li>
        <li>
            <a href="/" class="text-gray-700 hover:underline">© 2024 Gazi Social</a>
        </li>
    </ul>
</div>
