<div x-data="{ isGuest: {{ Auth::check() ? 'false' : 'true' }} }">
    <div class="bg-white rounded-xl shadow-md border border-gray-100">
        @guest
            <section
                class="bg-gradient-to-b from-blue-500 to-blue-700 px-6 md:px-24 text-center py-12 md:py-24 rounded-t-xl">
                <h1 class="text-white text-2xl md:text-4xl font-extrabold uppercase font-ginto">
                    GAZİ SOCİAL'A HOŞ GELDİNİZ
                </h1>
                <p class="text-white text-sm md:text-lg font-medium mt-3.5 md:w-full">
                    Gazi öğrencilerinin fikirlerini paylaştığı ve bir araya geldiği dijital topluluk.
                </p>
                <div class="flex items-center justify-center gap-2.5 mt-7 md:gap-4 md:mt-10">
                    <x-link href="{{ route('posts.create') }}"
                        class="rounded-md w-36 md:w-48 bg-white border border-white py-2 md:py-3 text-xs md:text-sm font-medium text-gray-900 bg-opacity-90 hover:bg-opacity-100 transition duration-300 hover:no-underline">
                        Yeni Konu Oluştur
                    </x-link>
                    <x-link href="{{ route('posts.create') }}"
                        class="rounded-md w-36 md:w-48 bg-white border border-white py-2 md:py-3 text-xs md:text-sm font-medium text-white bg-opacity-0 hover:bg-opacity-10 transition duration-300 hover:no-underline">
                        Nasıl Başlarım?
                    </x-link>
                </div>
            </section>
            <section class="mt-8 md:mt-16 mx-6 md:mx-24">
                <div class="flex items-center justify-evenly gap-3 md:gap-5 flex-wrap flex-col md:flex-row md:flex-nowrap">
                    <div
                        class="flex w-full md:w-1/3 items-center px-6 py-4 gap-3.5 bg-white border border-gray-200 rounded-lg shadow">
                        <div>
                            <x-icons.school size="45" class="text-red-500 size-10 md:size-14" />
                        </div>
                        <div>
                            <h2 class="text-base md:text-lg font-semibold text-gray-700">
                                Dijital Kampüs
                            </h2>
                            <p class="text-xs md:text-sm text-gray-500">
                                Kampüste olan biteni dijitalde keşfedin.
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex w-full md:w-1/3 items-center px-6 py-4 gap-3.5 bg-white border border-gray-200 rounded-lg shadow">
                        <div>
                            <x-icons.happy size="45" class="text-green-500 size-10 md:size-14" />
                        </div>
                        <div>
                            <h2 class="text-base md:text-lg font-semibold text-gray-700">
                                Reklam Yok
                            </h2>
                            <p class="text-xs md:text-sm text-gray-500">
                                Kar amacı gütmeyen bir platform.
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex w-full md:w-1/3 items-center px-6 py-4 gap-3.5 bg-white border border-gray-200 rounded-lg shadow">
                        <div>
                            <x-icons.code size="45" class="text-blue-500 size-10 md:size-14" />
                        </div>
                        <div>
                            <h2 class="text-base md:text-lg font-semibold text-gray-700">
                                Açık Kaynak
                            </h2>
                            <p class="text-xs md:text-sm text-gray-500">
                                Geliştirme sürecine katkıda bulunun.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        @endguest
        <section :class="{ 'p-6': !isGuest, 'mt-5 md:mt-12 mx-6 md:mx-24': isGuest }">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-gray-800 text-base md:text-xl font-semibold">Sabitlenmiş Konular</h3>
                    <p class="text-xs md:text-sm text-normal text-gray-400 font-normal w-3/4 md:w-full">
                        Sabitlenen son 3 konu listelenmiştir. Muhtemelen önemli içeriğe sahipler.
                    </p>
                </div>
                <x-link href="{{ route('posts.index') }}"
                    class="text-primary whitespace-nowrap text-xs md:text-sm font-medium">
                    Tümünü Gör
                </x-link>
            </div>
            <div class="mt-3 space-y-4">
                @foreach ($this->pinnedPosts as $post)
                    <div class="bg-white rounded-lg shadow border border-gray-100"
                        wire:key="pinned-post-{{ $post->id }}">
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-0 md:gap-2">
                                    <x-ui.tooltip text="Sabitlenmiş Konu">
                                        <x-icons.pin class="text-blue-500" size="20" />
                                    </x-ui.tooltip>
                                    <div class="ml-1.5 flex items-center justify-end md:justify-start gap-1 flex-wrap">
                                        @foreach ($post->tags as $tag)
                                            <x-post.post-tag :tag="$tag" :key="'tag-' . $tag->id" />
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 md:mt-3">
                                <h4 class="text-sm md:text-lg font-medium text-gray-700">
                                    {{ $post->title }}
                                </h4>
                                <p class="text-xs md:text-sm font-light text-gray-500 mt-1 md:mt-0">
                                    {{ substr(strip_tags($post->html), 0, 200) }}...
                                </p>
                            </div>
                            <div
                                class="mt-1.5 md:mt-3 flex items-end md:items-center justify-between gap-2.5 flex-wrap">
                                <div class="flex md:items-center flex-wrap flex-col md:flex-row gap-2">
                                    <div class="flex items-center gap-1">
                                        <x-icons.user class="text-blue-500" size="20" />
                                        <x-link href="{{ route('users.show', $post->user->username) }}"
                                            class="text-xs md:text-sm text-blue-500">
                                            {{ $post->user->name }}
                                        </x-link>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <x-icons.time class="text-blue-500" size="20" />
                                        <span class="text-xs md:text-sm text-gray-500">
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <x-link href="{{ $post->showRoute() }}" class="text-primary text-xs font-normal">
                                        Devamını oku
                                    </x-link>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="dev-center mt-7 md:mt-20 relative bg-blue-600">
            <div class="py-8 pb-12 md:py-12 px-10 md:px-24">
                <div class="flex flex-col items-center justify-center text-center">
                    <h3 class="text-xl md:text-3xl font-semibold text-white">Geliştirici Merkezi</h3>
                    <p class="mt-2 md:mt-1.5 text-gray-50 text-sm md:text-lg font-normal w-full md:w-3/4">
                        Gazi Social açık kaynaklı bir projedir. Geliştirme süreci ile ilgili içerikler "Dev Center" adlı
                        sayfada toplanmıştır.
                    </p>
                    <x-link href="{{ route('dev-center') }}"
                        class="text-white flex items-center justify-center gap-1 text-base md:text-lg font-medium mt-4">
                        Dev Center'a Git
                        <x-icons.arrow-right-alt size="20" />
                    </x-link>
                </div>
                <div class="mt-6 md:mt-12 text-center">
                    <p class="text-xs md:text-sm text-gray-100 font-light">
                        Proje <a target="_blank" href="https://www.gnu.org/licenses/gpl-3.0.en.html"
                            class="hover:underline italic">
                            GNU General Public License v3.0
                        </a> lisansı ile korunmaktadır.
                    </p>
                </div>
            </div>
        </section>
        @guest
            <section class="mt-7 mb-9 md:my-12 mx-6 md:mx-24">
                <div class="text-center">
                    <h3 class="text-xl md:text-3xl font-semibold text-gray-900">
                        Hemen Katılın ve Tartışmaya Başlayın
                    </h3>
                    <p class="text-sm md:text-lg font-normal text-gray-600 mt-2 mb-5 mb:mb-8">
                        Gazi Social topluluğuna katılın, bilgi paylaşın ve yeni arkadaşlıklar kurun.
                    </p>
                    <x-link href="{{ route('register') }}"
                        class="text-white text-xs md:text-sm font-medium bg-blue-600 px-4 py-2.5 md:px-6 md:py-3.5 rounded-md hover:no-underline hover:bg-blue-700 transition duration-300">
                        Ücretsiz Hesap Oluştur
                    </x-link>
                </div>
        </section> @endguest
    </div>
</div>
