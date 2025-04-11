<div class="flex items-center flex-col pt-16 p-6">
    <a href="/" class="h-20 mb-6 hover:opacity-90">
        <img src="{{ asset('\logos/GS_LOGO_DEFAULT.png') }}" alt="Gazi Social" class="object-contain h-full w-full">
    </a>
    <div class="bg-slate-50 border border-slate-200 px-8 pt-6 pb-8 mb-4 rounded-lg max-w-md w-full shadow-sm">
        <div class="flex flex-col gap-2 text-center">
            <h1 class="font-semibold text-lg mb-1 text-primary">E-posta Adresinizi Doğrulayın</h1>
            <p class="text-gray-600 font-normal text-sm mb-4">
                Kaydınızı tamamlamak için lütfen e-posta adresinize gönderilen 6 haneli doğrulama kodunu girin.
            </p>

            <div class="bg-blue-50 rounded-lg p-3 mb-3 text-blue-700 text-sm">
                <p>Doğrulama kodunu içeren e-posta <strong>{{ auth()->user()->email }}</strong> adresine gönderildi.</p>
                <p class="mt-1"><strong>Spam klasörünüzü kontrol etmeyi unutmayın.</strong></p>
            </div>

            <form wire:submit="verifyCode" class="mt-1">
                @csrf
                <div class="mb-2">
                    <div class="relative">
                        <input wire:model="verification_code" id="verification_code" type="text"
                            class="w-full h-14 shadow-sm appearance-none border border-gray-300 rounded-lg py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary text-center tracking-widest font-mono font-semibold text-xl"
                            placeholder="6 haneli kod" maxlength="6" autocomplete="off" inputmode="numeric"
                            pattern="[0-9]*">

                        <button type="submit"
                            class="mt-3 bg-primary text-white font-medium rounded-lg py-3 w-full flex items-center justify-center transition hover:bg-opacity-90 focus:outline-none"
                            wire:loading.class="opacity-75 cursor-not-allowed" wire:loading.attr="disabled"
                            wire:target="verifyCode">
                            <span wire:loading.remove wire:target="verifyCode">Hesabımı Doğrula</span>
                            <x-icons.spinner wire:loading wire:target="verifyCode" size="20" class="text-white" />
                        </button>
                    </div>
                </div>
            </form>

            <div class="border-t border-gray-200 pt-4 mt-2">
                <p class="text-sm text-gray-600 mb-3">Doğrulama kodunu almadınız mı?</p>
                <form wire:submit="sendVerifyMail">
                    @csrf
                    <button wire:loading.class="bg-gray-200 cursor-not-allowed" wire:target="sendVerifyMail"
                        wire:loading.class.remove="bg-gray-100 hover:bg-gray-200" wire:loading.attr="disabled"
                        class="bg-gray-100 flex items-center h-[40px] gap-1 overflow-hidden justify-center hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline w-full transition"
                        type="submit">
                        <x-icons.spinner wire:loading size="20" wire:target="sendVerifyMail"
                            class="text-primary" />
                        <span wire:loading.remove wire:target="sendVerifyMail">Yeni Kod Gönder</span>
                    </button>
                </form>
            </div>
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
