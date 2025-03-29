<div class="shadow-sm bg-gradient-to-bl from-sky-50 to-blue-100 rounded-xl px-8 py-6 mb-6 select-none relative">
    <div class="absolute right-20 top-6 text-blue-800/50 hidden lg:block">
        <x-icons.mail size="120" />
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
                class="text-indigo-900 text-xs flex items-center gap-0.5 mt-2 w-fit font-bold">
                Hesabımı doğrula <x-icons.arrow-right-alt size="16" />
            </x-link>
        </div>
    </div>
</div>
