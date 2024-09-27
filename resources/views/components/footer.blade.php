<footer class="rounded-xl mx-[3%] md:mx-[6%] lg:mx-[12%] mt-4 md:mt-8 mb-4 md:mb-8 py-3 md:py-4 md:px-0 px-2">
    <div class="flex gap-1 flex-wrap md:flex-nowrap md:gap-5 items-center justify-between">
        <div class="flex flex-col gap-2 py-4">
            <h4 class="md:text-lg font-semibold text-gray-800">Gazi Social</h4>
            <x-link href=""
                class="text-sm md:text-base text-gray-500 hover:text-primary hover:no-underline">Anasayfa</x-link>
            <x-link href=""
                class="text-sm md:text-base text-gray-500 hover:text-primary hover:no-underline">Hakkımızda</x-link>
            <x-link href=""
                class="text-sm md:text-base text-gray-500 hover:text-primary hover:no-underline">İletişim</x-link>
        </div>
        <div class="flex flex-col gap-2 py-4">
            <h4 class="md:text-lg font-semibold text-gray-800">Hizmetlerimiz</h4>
            <x-link href=""
                class="text-sm md:text-base text-gray-500 hover:text-primary hover:no-underline">Forum</x-link>
            <x-link href=""
                class="text-sm md:text-base text-gray-500 hover:text-primary hover:no-underline">Blog</x-link>
            <x-link href=""
                class="text-sm md:text-base text-gray-500 hover:text-primary hover:no-underline">Etkinlikler</x-link>
        </div>
        <div class="flex flex-col gap-2 py-4">
            <h4 class="md:text-lg font-semibold text-gray-800">Yardım</h4>
            <x-link href=""
                class="text-sm md:text-base text-gray-500 hover:text-primary hover:no-underline">SSS</x-link>
            <x-link href="{{ route('terms') }}"
                class="text-sm md:text-base text-gray-500 hover:text-primary hover:no-underline">Kullanım
                Koşulları</x-link>
            <x-link href=""
                class="text-sm md:text-base text-gray-500 hover:text-primary hover:no-underline">Gizlilik
                Politikası</x-link>
        </div>
    </div>
    <div class="flex justify-between mt-4 flex-col-reverse md:flex-row gap-2 lg:mt-8 md:items-center">
        <span class="text-gray-500 text-sm">© 2024 Gazi Social</span>
        <span class="text-sm text-gray-400 italic">"Sosyalleşmenin yeni adresi..."</span>
        <div class="flex items center gap-4">
            <x-link href="" class="text-gray-500 hover:text-primary">
                <x-icons.social.github size='22' />
            </x-link>
            <x-link href="" class="text-gray-500 hover:text-primary">
                <x-icons.social.x size='22' />
            </x-link>
            <x-link href="" class="text-gray-500 hover:text-primary">
                <x-icons.social.instagram size='22' />
            </x-link>
        </div>
    </div>
</footer>
