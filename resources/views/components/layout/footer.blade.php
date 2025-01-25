<div class="mt-7 md:mt-14">
    <button onclick="window.scrollTo(0, 0)" type="button"
        class="w-full py-4 bg-blue-900 text-sm hover:bg-blue-800 font-medium text-gray-200">
        Başa dön
    </button>
    <footer class="py-12 px-[3%] md:px-[6%] lg:px-[12%] bg-blue-950">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="mb-4 md:mb-0">
                <div class="w-36 md:w-48 mb-3.5">
                    <img src="{{ asset('logos/GS_LOGO_BLUE_WHITE.png') }}" alt="logo" class="size-full object-cover">
                </div>
                <p class="text-gray-100 text-lg md:text-xl italic font-satisfy font-light">
                    Gazili olmak ayrıcalıktır
                </p>
            </div>
            <div class="flex gap-2 flex-col text-gray-200">
                <h6 class="text-white font-semibold mb-1 text-lg">Gazi Social</h6>
                <div class="flex flex-col gap-2">
                    <x-link href="{{ route('home') }}" class="font-normal text-sm self-start">
                        Ana Sayfa
                    </x-link>
                    <x-link href="{{ route('about') }}" class="font-normal text-sm self-start">
                        Hakkımızda
                    </x-link>
                    @guest
                        <x-link href="{{ route('register') }}" class="font-normal text-sm self-start">
                            Kayıt Ol
                        </x-link>
                    @endguest
                    @auth
                        <x-link href="{{ route('users.edit', Auth::user()->username) }}"
                            class="font-normal text-sm self-start">
                            Hesabım
                        </x-link>
                    @endauth
                </div>
            </div>
            <div class="flex gap-2 flex-col text-gray-200">
                <h6 class="text-white font-semibold mb-1 text-lg">İletişim</h6>
                <div class="flex flex-col gap-2">
                    <x-link href="{{ route('contact') }}" class="font-normal text-sm self-start">
                        Mesaj Gönder
                    </x-link>
                    <x-link href="{{ route('report-a-bug') }}" class="font-normal text-sm self-start">
                        Hata Bildir
                    </x-link>
                    <x-link href="{{ route('reported-bugs') }}" class="font-normal text-sm self-start">
                        Bildirilen Hatalar
                    </x-link>
                </div>
            </div>
            <div class="flex gap-2 flex-col text-gray-200">
                <h6 class="text-white font-semibold mb-1 text-lg">Yardım</h6>
                <div class="flex flex-col gap-2">
                    <x-link href="{{ route('faq') }}" class="font-normal text-sm self-start">
                        SSS
                    </x-link>
                    <x-link href="{{ route('privacy') }}" class="font-normal text-sm self-start">
                        Gizlilik Politikası
                    </x-link>
                    <x-link href="{{ route('terms') }}" class="font-normal text-sm self-start">
                        Kullanım Koşulları
                    </x-link>
                </div>
            </div>
            <div class="flex gap-2 flex-col text-gray-200">
                <h6 class="text-white font-semibold mb-1 text-lg">Dev Center</h6>
                <div class="flex flex-col gap-2">
                    <x-link href="{{ route('dev-center') }}" class="font-normal text-sm self-start">
                        Introduction
                    </x-link>
                    <x-link href="{{ route('how-to-contribute') }}" class="font-normal text-sm self-start">
                        Contribution Guide
                    </x-link>
                    <x-link href="{{ route('contributors') }}" class="font-normal text-sm self-start">
                        Contributors
                    </x-link>
                </div>
            </div>
        </div>
        <div class="my-8 opacity-30">
            <x-seperator />
        </div>
        @if (request()->is('dev-center*'))
            <div class="w-full text-gray-300 mb-1.5 text-sm md:text-center font-light">
                <span>
                    You are currently on the <a wire:navigate class="text-blue-200 hover:underline"
                        href="{{ route('dev-center') }}">Dev Center</a>
                    pages.
                </span>
            </div>
        @endif
        <div class="w-full text-gray-300 mb-1.5 text-sm md:text-center font-light">
            <span>Made with 🧠 by contributors and </span>
            <a href="https://github.com/yehuuu6" target="_blank"
                class="text-blue-200 font-normal hover:underline">@yehuuu6</a>
        </div>
        <div class="w-full text-gray-300 md:text-center text-sm font-light">
            <a href="https://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank" class="hover:underline">GPLv3</a>
            <span> | </span>
            <a href="https://github.com/yehuuu6/gazisocial" target="_blank" class="hover:underline">GitHub</a>
            <span> | </span>
            <span>Copyright © Gazi Social 2025 All rights reserved.</span>
        </div>
    </footer>
</div>
