<div class="mt-auto">
    <footer class="py-12 px-[3%] xl:px-[6%] 2xl:px-[12%] bg-blue-950">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div class="mb-4 md:mb-0">
                <div class="w-36 md:w-48 mb-3.5">
                    <img src="{{ asset('\logos/GS_LOGO_BLUE_WHITE.png') }}" alt="logo" class="size-full object-cover">
                </div>
                <p class="text-gray-100 text-lg md:text-xl italic font-medium font-satisfy">
                    Gazili olmak ayrıcalıktır
                </p>
            </div>
            <div class="flex flex-col md:flex-row md:items-center justify-end md:justify-start gap-6 md:gap-24">
                <div class="flex gap-2 flex-col text-gray-200">
                    <h6 class="text-white font-semibold mb-1 text-lg">Gazi Social</h6>
                    <div class="flex flex-col gap-2">
                        <x-link href="{{ route('home') }}" class="font-medium text-sm self-start md:self-end">
                            Ana Sayfa
                        </x-link>
                        <x-link href="{{ route('about') }}" class="font-medium text-sm self-start md:self-end">
                            Hakkımızda
                        </x-link>
                        @guest
                            <x-link href="{{ route('register') }}" class="font-medium text-sm self-start md:self-end">
                                Kayıt Ol
                            </x-link>
                        @endguest
                        @auth
                            <x-link href="{{ route('users.edit', Auth::user()->username) }}"
                                class="font-medium text-sm self-start md:self-end">
                                Hesabım
                            </x-link>
                        @endauth
                    </div>
                </div>
                <div class="flex gap-2 flex-col text-gray-200">
                    <h6 class="text-white font-semibold mb-1 text-lg">Oyun Merkezi</h6>
                    <div class="flex flex-col gap-2">
                        <x-link href="{{ route('games.index') }}" class="font-medium text-sm self-start md:self-end">
                            Oyunlar
                        </x-link>
                        <x-link href="{{ route('games.zk.guide') }}" class="font-medium text-sm self-start md:self-end">
                            Zalim Kasaba
                        </x-link>
                        <x-link href="games/cb" class="font-medium text-sm self-start md:self-end">
                            Çiz Bil (Yakında)
                        </x-link>
                    </div>
                </div>
                <div class="flex gap-2 flex-col text-gray-200">
                    <h6 class="text-white font-semibold mb-1 text-lg self-start md:self-end">Yardım</h6>
                    <div class="flex flex-col gap-2">
                        <x-link href="{{ route('faq') }}" class="font-medium text-sm self-start md:self-end">
                            SSS
                        </x-link>
                        <x-link href="{{ route('privacy') }}" class="font-medium text-sm self-start md:self-end">
                            Gizlilik Politikası
                        </x-link>
                        <x-link href="{{ route('terms') }}" class="font-medium text-sm self-start md:self-end">
                            Kullanım Koşulları
                        </x-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-8 opacity-30">
            <x-seperator />
        </div>
        <div class="w-full font-medium text-gray-300 mb-1.5 text-sm md:text-center">
            <span>Made with 🧠 by </span>
            <a href="https://github.com/yehuuu6" target="_blank" class="text-blue-200 hover:underline">@yehuuu6</a>
        </div>
        <div class="w-full font-medium text-gray-300 md:text-center text-sm">
            <span>
                Copyright © Gazi Social {{ date('Y') }} All rights reserved.
            </span>
        </div>
    </footer>
</div>
