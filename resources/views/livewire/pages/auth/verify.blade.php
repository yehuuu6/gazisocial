<div class="flex items-center justify-center flex-col h-dvh">
    <div class="bg-gray-50 border border-gray-200 px-8 pt-6 pb-8 mb-4 rounded-lg max-w-md w-full">
        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-5"
                role="alert">
                <h1 class="text-center text-sm">Doğrulama bağlantısı başarıyla gönderildi!</h1>
            </div>
        @endif
        <div class="flex flex-col gap-2 text-center">
            <div class="flex items-center justify-center relative">
                <span class="absolute top-[0.30rem] left-[12.75rem] w-4 h-4 bg-blue-500 rounded-full"></span>
                <span
                    class="animate-ping absolute top-[0.30rem] left-[12.75rem] w-4 h-4 bg-blue-500 rounded-full"></span>
                <svg class="size-14 text-blue-300" stroke="currentColor" fill="currentColor" stroke-width="0"
                    viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M460.6 147.3L353 256.9c-.8.8-.8 2 0 2.8l75.3 80.2c5.1 5.1 5.1 13.3 0 18.4-2.5 2.5-5.9 3.8-9.2 3.8s-6.7-1.3-9.2-3.8l-75-79.9c-.8-.8-2.1-.8-2.9 0L313.7 297c-15.3 15.5-35.6 24.1-57.4 24.2-22.1.1-43.1-9.2-58.6-24.9l-17.6-17.9c-.8-.8-2.1-.8-2.9 0l-75 79.9c-2.5 2.5-5.9 3.8-9.2 3.8s-6.7-1.3-9.2-3.8c-5.1-5.1-5.1-13.3 0-18.4l75.3-80.2c.7-.8.7-2 0-2.8L51.4 147.3c-1.3-1.3-3.4-.4-3.4 1.4V368c0 17.6 14.4 32 32 32h352c17.6 0 32-14.4 32-32V148.7c0-1.8-2.2-2.6-3.4-1.4z">
                    </path>
                    <path
                        d="M256 295.1c14.8 0 28.7-5.8 39.1-16.4L452 119c-5.5-4.4-12.3-7-19.8-7H79.9c-7.5 0-14.4 2.6-19.8 7L217 278.7c10.3 10.5 24.2 16.4 39 16.4z">
                    </path>
                </svg>
            </div>
            <h1 class="font-medium text-lg">E-posta Adresinizi Doğrulayın</h1>
            <p class="text-gray-600 font-normal text-sm">
                Kaydınızı tamamlamak için lütfen e-posta adresinizi doğrulayın. Bu, hesabınızı güvende tutmamıza
                yardımcı olur. <br>
                <strong>Eğer e-postayı almadıysanız,</strong>
            <form wire:submit="sendVerifyMail" class="d-inline">@csrf<button wire:loading.class="animate-pulse"
                    class="bg-primary mt-3 opacity-90 hover:opacity-100 text-white font-medium py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                    type="submit">
                    Yeniden Gönder
                </button>
            </form>
            </p>
        </div>
    </div>
</div>
