<div class="shadow-sm bg-gradient-to-bl from-sky-50 to-blue-100 rounded-xl px-8 py-6 mb-6 select-none relative">
    <div class="absolute right-20 top-6 text-blue-800/50 hidden lg:block">
        <x-tabler-mail class="size-32" />
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="max-w-xl">
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-lg text-blue-950 font-bold">
                    E-posta adresinizi doğrulayın
                </h1>
            </div>
            <p class="text-xs text-blue-800 leading-relaxed">
                Lütfen hesabınızın tam işlevselliğine erişmek için e-posta adresinizi doğrulayın. Doğrulama e-postası
                bulamadıysanız, aşağıdaki düğmeyi kullanarak yeni bir doğrulama e-postası gönderebilirsiniz.
            </p>
            <x-link href="{{ route('verification.notice') }}"
                class="inline-flex items-center gap-1 mt-2 text-xs text-indigo-900 font-semibold hover:underline">
                Hesabımı doğrula <x-tabler-arrow-right class="size-3.5 mb-0.5" />
            </x-link>
        </div>
    </div>
</div>
