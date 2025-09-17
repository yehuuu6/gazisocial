<div>
    <section class="bg-white rounded-xl shadow-md border p-6 md:p-10 border-gray-100">
        <div class="text-center">
            <h3
                class="text-4xl lg:text-6xl font-extrabold bg-gradient-to-bl from-sky-300 to-blue-800 bg-clip-text text-transparent leading-normal">
                Oyun Merkezi
            </h3>
            <p class="mt-1.5 text-gray-700 text-base md:text-lg font-semibold mx-5">
                Gazi Social oyun merkezinde arkadaşlarınızla ister uzaktan, ister yan yana oyunlar oynayabilirsiniz.
            </p>
        </div>
        <div class="mt-6 md:mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:mx-20 lg:mx-28">
            <div class="rounded-lg shadow-sm overflow-hidden border border-gray-200">
                <a href="/games/zk" class="relative">
                    <img alt="Zalim Kasaba" width="400" height="200" class="w-full h-48 object-cover"
                        src="{{ asset('zalim-kasaba/zalim-kasaba-banner.jpg') }}" style="color: transparent;">
                    <div
                        class="inline-flex items-center border-2 border-white rounded-full px-2.5 py-0.5 text-xs font-semibold bg-red-600 absolute top-3 right-3 text-white">
                        Rol Yapma
                    </div>
                </a>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">Zalim Kasaba</h3>
                    <p class="text-gray-600 text-sm line-clamp-2">
                        Town of Salem ve Vampir Köyü oyunlarından esinlenerek geliştirdiğimiz, minimum 7 kişilik,
                        maksimum 15 kişilik oyun.
                    </p>
                </div>
                <a href="{{ route('games.zk.guide') }}"
                    class="flex items-center gap-0.5 px-4 mb-4 text-sm font-medium text-primary hover:underline">
                    Detaylar <x-tabler-chevron-right class="inline-block size-4" />
                </a>
            </div>
            <div class="rounded-lg shadow-sm overflow-hidden border border-gray-200">
                <a href="/games/cb" class="relative">
                    <img alt="Zalim Kasaba" width="400" height="200" class="w-full h-48 object-cover"
                        src="{{ asset('placeholder.svg') }}" style="color: transparent;">
                    <div
                        class="inline-flex items-center border-2 border-white rounded-full px-2.5 py-0.5 text-xs font-semibold bg-red-600 absolute top-3 right-3 text-white">
                        Çizim ve Tahmin
                    </div>
                    <div
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-lg font-bold bg-gray-300 bg-opacity-50 px-3 py-1 text-gray-600 rounded-full">
                        Çok Yakında
                    </div>
                </a>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">
                        Çiz Bil
                    </h3>
                    <p class="text-gray-600 text-sm line-clamp-2">
                        Çiz Bil, arkadaşlarınızla birlikte çizim yapıp tahminlerde bulunarak eğlenceli vakit
                        geçirebileceğiniz
                        bir oyun.
                    </p>
                </div>
                <a href="/games/cb/guide"
                    class="flex items-center gap-0.5 px-4 mb-4 text-sm font-medium text-primary hover:underline">
                    Detaylar <x-tabler-chevron-right class="inline-block size-4" />
                </a>
            </div>
        </div>
    </section>
</div>
