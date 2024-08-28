<div class="flex items-center flex-col mt-6">
    <div class="flex items-center justify-center flex-col gap-5">
        <a href="/" wire:navigate><img src="{{ asset('gazi-logo.png') }}" class="w-14 h-14"></a>
        <h3 class="text-center mb-6 text-2xl font-light">Gazi Social'a Katıl</h3>
    </div>
    <div class="w-full max-w-md">
        <div class="bg-white border border-gray-200 p-6 mb-4 rounded-lg">
            <p class="text-gray-600 text-sm text-center">
                Onaylı hesap sahibi olmak için <strong class="text-gray-700">@gazi.edu.tr</strong> uzantılı bir e-posta
                adresi
                kullanılmalıdır.<br>
                <a href="https://gazi.edu.tr/view/announcement/303951/e-posta-talep-sistemi"
                    class="text-blue-600 hover:underline" target="_blank">Daha fazla bilgi almak için tıklayın.</a>
            </p>
        </div>
        <livewire:components.auth.register-form />
    </div>
    <div class="text-center">
        <p class="text-gray-600 text-sm">Zaten bir hesabınız var mı?
            <x-link href="/login" class="inline-block align-baseline font-normal text-sm text-blue-600">Giriş
                Yapın</x-link>
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
