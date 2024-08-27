<div class="flex items-center flex-col mt-6">
    <div class="flex items-center justify-center flex-col gap-5">
        <a href="/" wire:navigate><img src="{{ asset('gazi-logo.png') }}" alt="" class="w-14 h-14"></a>
        <h3 class="text-center mb-5 text-2xl font-light">Gazi Social'a Giriş Yap</h3>
    </div>
    <livewire:components.auth.login-form />
    <div class="text-center">
        <p class="text-gray-600 text-sm">Hesabınız yok mu?
            <x-link href="/register" class="inline-block align-baseline font-normal text-sm text-blue-600">Kayıt
                Olun</x-link>
        </p>
        <p class="text-gray-600 text-sm mt-2">Şifrenizi mi unuttunuz?
            <x-link href="/forgot-password"
                class="inline-block align-baseline font-normal text-sm text-blue-600">Şifremi
                Sıfırla</x-link>
        </p>
    </div>
    <ul class="text-xs p-6 mt-4 rounded-lg flex gap-10">
        <li>
            <x-link href="/" class="text-gray-700">Terms</x-link>
        </li>
        <li>
            <x-link href="/" class="text-gray-700">Privacy</x-link>
        </li>
        <li>
            <x-link href="/" class="text-gray-700">Cookies</x-link>
        </li>
        <li>
            <x-link href="/" class="text-gray-700">Help</x-link>
        </li>
        <li>
            <x-link href="/" class="text-gray-700">© 2024 Gazi Social</x-link>
        </li>
    </ul>
</div>
