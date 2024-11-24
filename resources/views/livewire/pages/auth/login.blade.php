<div class="flex items-center flex-col mt-6 p-6">
    <a href="/" class="h-20 mb-6 hover:opacity-90">
        <img src="{{ asset('logos/GS_LOGO_DEFAULT.png') }}" alt="Gazi Social" class="object-contain h-full w-full">
    </a>
    <livewire:components.auth.login-form />
    <div class="text-center">
        <p class="text-gray-600 text-sm">Hesabınız yok mu?
            <a href="/register"
                class="inline-block align-baseline font-normal text-sm text-blue-600 hover:underline">Kayıt
                Olun</a>
        </p>
        <p class="text-gray-600 text-sm mt-2">Şifrenizi mi unuttunuz?
            <a href="/forgot-password"
                class="inline-block align-baseline font-normal text-sm text-blue-600 hover:underline">Şifremi
                Sıfırla</a>
        </p>
    </div>
    <ul class="text-xs p-3 md:p-6 mt-2 md:mt-4 rounded-lg flex gap-4 md:gap-10 flex-wrap items-center justify-center">
        <li>
            <a href="{{ route('terms') }}" class="text-gray-700 hover:underline">Kullanıcı Sözleşmesi</a>
        </li>
        <li>
            <a href="{{ route('privacy') }}" class="text-gray-700 hover:underline">Gizlilik</a>
        </li>
        <li>
            <a href="/" class="text-gray-700 hover:underline">© 2024 Gazi Social</a>
        </li>
    </ul>
</div>
