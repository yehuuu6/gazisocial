<div class="flex items-center flex-col mt-6 p-6">
    <div class="flex items-center justify-center flex-col gap-5">
        <a href="/"><img src="{{ asset('gazi-logo.png') }}" alt="" class="w-14 h-14"></a>
        <h3 class="text-center mb-5 text-2xl font-light">Gazi Social'a Giriş Yap</h3>
    </div>
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
            <a href="/" class="text-gray-700 hover:underline">Terms</a>
        </li>
        <li>
            <a href="/" class="text-gray-700 hover:underline">Privacy</a>
        </li>
        <li>
            <a href="/" class="text-gray-700 hover:underline">Cookies</a>
        </li>
        <li>
            <a href="/" class="text-gray-700 hover:underline">Help</a>
        </li>
        <li>
            <a href="/" class="text-gray-700 hover:underline">© 2024 Gazi Social</a>
        </li>
    </ul>
</div>
