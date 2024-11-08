<footer class="mx-[3%] mb-4 mt-4 rounded-xl px-2 py-3 md:mx-[6%] md:mb-8 md:mt-8 md:px-0 md:py-4 lg:mx-[12%]">
    <div class="flex flex-wrap items-center justify-between gap-1 md:flex-nowrap md:gap-5">
        <div class="flex flex-col gap-2 py-4">
            <h4 class="font-semibold text-gray-800 md:text-lg">Gazi Social</h4>
            <x-link href=""
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Anasayfa</x-link>
            <x-link href=""
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Hakkımızda</x-link>
            <x-link href=""
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">İletişim</x-link>
        </div>
        <div class="flex flex-col gap-2 py-4">
            <h4 class="font-semibold text-gray-800 md:text-lg">Hizmetlerimiz</h4>
            <x-link href=""
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Forum</x-link>
            <x-link href=""
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Blog</x-link>
            <x-link href=""
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Etkinlikler</x-link>
        </div>
        <div class="flex flex-col gap-2 py-4">
            <h4 class="font-semibold text-gray-800 md:text-lg">Yardım</h4>
            <x-link href=""
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">SSS</x-link>
            <x-link href="{{ route('terms') }}"
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Kullanım
                Koşulları</x-link>
            <x-link href=""
                class="text-sm text-gray-500 hover:text-primary hover:no-underline md:text-base">Gizlilik
                Politikası</x-link>
        </div>
    </div>
    <div class="mt-4 flex flex-col-reverse justify-between gap-6 md:flex-row md:items-center lg:mt-8">
        <div class="items center flex gap-4">
            <a target="_blank" href="https://github.com/yehuuu6/gazisocial" class="text-gray-500 hover:text-primary">
                <x-icons.social.github size='22' />
            </a>
            <a target="_blank" href="https://x.com/therenaydin" class="text-gray-500 hover:text-primary">
                <x-icons.social.x size='22' />
            </a>
            <a target="_blank" href="https://instagram.com/therenaydin" class="text-gray-500 hover:text-primary">
                <x-icons.social.instagram size='22' />
            </a>
        </div>
        <div class="flex flex-col gap-2 md:items-end text-gray-500">
            <span>Made with 🧠 & <a target="_blank" class="text-cyan-400 hover:underline"
                    href="https://tallstack.dev/">TALL stack</a>
                by <a target="_blank" class="text-primary hover:underline"
                    href="https://instagram.com/therenaydin">@therenaydin</a></span>
            <span class="text-gray-500">Copyright © 2024 All rights reserved.</span>
        </div>
    </div>
</footer>
