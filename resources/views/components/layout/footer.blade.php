<footer class="mx-[3%] mb-4 mt-4 rounded-xl px-2 py-3 md:mx-[6%] md:mb-8 md:mt-8 md:px-0 md:py-4 lg:mx-[12%]">
    <div class="flex flex-wrap items-start justify-between gap-1 md:flex-nowrap md:gap-5">
        <div class="flex flex-col gap-2 py-4">
            <h4 class="font-semibold text-gray-800 md:text-lg">Gazi Social</h4>
            <x-link href="{{ route('home') }}"
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Ana
                Sayfa</x-link>
            <x-link href="{{ route('about') }}"
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Hakkımızda</x-link>
            @guest
                <a href="{{ route('login') }}"
                    class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Giriş
                    Yap</a>
            @endguest
            @auth
                <x-link href="{{ route('users.show', Auth::user()) }}"
                    class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Hesabım</x-link>
            @endauth
        </div>
        <div class="flex flex-col gap-2 py-4">
            <h4 class="font-semibold text-gray-800 md:text-lg">İletişim</h4>
            <x-link href="{{ route('contact') }}"
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Bizimle İletişime
                Geç</x-link>
            <x-link href="{{ route('bugs') }}"
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Hata Bildir</x-link>
        </div>
        <div class="flex flex-col gap-2 py-4">
            <h4 class="font-semibold text-gray-800 md:text-lg">Yardım</h4>
            <x-link href="{{ route('faq') }}"
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">SSS</x-link>
            <x-link href="{{ route('terms') }}"
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Kullanım
                Koşulları</x-link>
            <x-link href="{{ route('privacy') }}"
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Gizlilik
                Politikası</x-link>
        </div>
        <div class="flex flex-col gap-2 py-4">
            <h4 class="font-semibold text-gray-800 md:text-lg">Dev Center</h4>
            <x-link href="{{ route('how-to-contribute') }}"
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">
                Contribution Guide
            </x-link>
            <x-link href="{{ route('reported-bugs') }}"
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Reported Bugs</x-link>
            <x-link href="{{ route('contributors') }}"
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Contributors</x-link>
        </div>
    </div>
    <div class="mt-4 flex flex-col-reverse justify-between gap-6 md:flex-row md:items-center lg:mt-8">
        <div class="flex items-center gap-4">
            <a target="_blank" href="https://github.com/yehuuu6/gazisocial"
                class="flex items-center gap-1.5 text-gray-500 text-sm md:text-base hover:underline">
                <x-icons.github size="20" />
                <span>GitHub Repository</span>
            </a>
        </div>
        <div class="flex flex-col gap-2 md:items-end text-gray-500 text-sm md:text-base">
            <span>Made with 🧠
                by contributors and <a target="_blank" class="text-primary hover:underline"
                    href="https://instagram.com/therenaydin">@therenaydin</a>.</span>
            <span class="text-gray-500">Copyright © 2025 All rights reserved.</span>
        </div>
    </div>
</footer>
