<div class="flex items-center flex-col mt-6 p-6">
    <a href="/" class="h-20 mb-6 hover:opacity-90">
        <img src="{{ asset('logos/GS_LOGO_DEFAULT.png') }}" alt="Gazi Social" class="object-contain h-full w-full">
    </a>
    <div class="w-full max-w-md">
        <div class="bg-white border border-gray-200 p-6 mb-4 rounded-lg">
            <p class="text-gray-600 text-sm text-center">
                Onaylı hesap sahibi olmak için <strong class="text-gray-700">@gazi.edu.tr</strong> uzantılı bir e-posta
                adresi
                kullanılmalıdır.<br>
                <a href="{{ route('faq') }}" class="text-blue-600 hover:underline">Daha fazla bilgi almak için
                    tıklayın.</a>
            </p>
        </div>
        <livewire:components.auth.register-form />
    </div>
    <div class="text-center">
        <p class="text-gray-600 text-sm">Zaten bir hesabınız var mı?
            <a href="/login"
                class="inline-block align-baseline font-normal text-sm text-blue-600 hover:underline">Giriş
                Yapın</a>
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
