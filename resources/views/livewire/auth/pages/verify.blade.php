<div class="flex items-center flex-col pt-16 p-6">
    <a href="/" class="h-20 mb-6 hover:opacity-90">
        <img src="{{ asset('\logos/GS_LOGO_DEFAULT.png') }}" alt="Gazi Social" class="object-contain h-full w-full">
    </a>
    <div class="bg-slate-50 border border-slate-200 px-8 pt-6 pb-8 mb-4 rounded-lg max-w-md w-full">
        <div class="flex flex-col gap-2 text-center">
            <div class="flex items-center justify-center relative">
                <span class="absolute top-0.5 left-52 size-4 bg-blue-300 rounded-full"></span>
                <span class="animate-ping absolute top-0.5 left-52 size-4 bg-blue-300 rounded-full"></span>
                <x-icons.mail size="58" class="text-primary" />
            </div>
            <h1 class="font-medium text-lg">E-posta Adresinizi Doğrulayın</h1>
            <p class="text-gray-600 font-normal text-sm mb-2">
                Kaydınızı tamamlamak için lütfen e-posta adresinizi doğrulayın. Bu, sizi ve Gazi Social topluluğunu
                güvende tutmamıza yardımcı olur. <br>
                <strong class="text-gray-700">
                    Eğer e-postayı almadıysanız, "Spam" kutusuna bakmayı unutmayın.
                </strong>
            </p>
            <form wire:submit="sendVerifyMail">
                @csrf
                <button wire:loading.class="bg-gray-200 cursor-not-allowed"
                    wire:loading.class.remove = "bg-primary hover:bg-opacity-100" wire:loading.attr="disabled"
                    class="bg-primary flex items-center h-[40px] gap-1 overflow-hidden justify-center bg-opacity-90 hover:bg-opacity-100 text-white font-medium py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                    type="submit">
                    <x-icons.spinner wire:loading size="32" color="#479fff" />
                    <span wire:loading.remove>Yeniden Gönder</span>
                </button>
            </form>
        </div>
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
            <a href="/" class="text-gray-700 hover:underline">© 2025 Gazi Social</a>
        </li>
    </ul>
</div>
