<div>
    <div class="bg-white rounded-xl shadow-md border border-gray-100">
        <section
            class="bg-gradient-to-b from-blue-500 to-blue-700 px-6 md:px-24 text-center py-12 md:py-24 rounded-t-xl">
            <h1 class="text-white text-xl md:text-3xl lg:text-4xl font-extrabold uppercase font-ginto">
                GAZİ SOCİAL'A HOŞ GELDİNİZ
            </h1>
            <p class="text-white text-sm md:text-lg font-medium mt-3.5 md:w-full">
                Haberler, etkinlikler, oyunlar ve daha fazlası için Gazi Social topluluğuna katılın.
            </p>
            <div class="flex items-center justify-center gap-2 mt-7 md:gap-4 md:mt-10">
                <x-link href="{{ route('posts.index', 'popular') }}"
                    class="text-gray-800 hover:border-blue-100 border border-white text-xs w-36 md:w-48 md:text-sm font-medium bg-blue-50 py-2 md:py-3 rounded-md hover:no-underline hover:bg-blue-100 transition duration-300">
                    Konuları Keşfet
                </x-link>
                @auth
                    <x-link href="{{ route('games.index') }}"
                        class="rounded-md w-36 md:w-48 bg-white border border-white py-2 md:py-3 text-xs md:text-sm font-medium text-white bg-opacity-0 hover:bg-opacity-10 transition duration-300 hover:no-underline">
                        Oyun Merkezine Git
                    </x-link>
                @endauth
                @guest
                    <x-link href="{{ route('register') }}"
                        class="rounded-md w-36 md:w-48 bg-white border border-white py-2 md:py-3 text-xs md:text-sm font-medium text-white bg-opacity-0 hover:bg-opacity-10 transition duration-300 hover:no-underline">
                        Kayıt Ol
                    </x-link>
                @endguest
            </div>
        </section>
        <section class="px-6 md:px-16 lg:px-24 border-b border-gray-200">
            <div class="py-5 flex-col 2xl:flex-row flex items-center justify-between">
                <div class="flex items-center gap-2 text-gray-800 flex-grow flex-shrink-0">
                    <x-icons.trending size="20" />
                    <h3 class="text-sm lg:text-base font-semibold">
                        Popüler Etiketler
                    </h3>
                </div>
                <div class="mt-3 2xl:mt-0 flex items-center justify-center 2xl:justify-end gap-2 flex-wrap">
                    @foreach ($this->popularTags as $tag)
                        <x-link href="{{ route('tags.show', $tag->slug) }}" wire:key="tag-{{ $tag->id }}"
                            class="bg-white hover:bg-gray-50 rounded-full px-2 py-0.5 md:px-2.5 md:py-1 text-xs font-semibold capitalize text-gray-800 border border-gray-200 transition-all duration-100 hover:bg-opacity-90 hover:no-underline">
                            {{ $tag->name }} <span class="text-gray-500 font-medium">({{ $tag->posts_count }})</span>
                        </x-link>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="mb-9 mt-4 mx-6 md:mb-12 md:mt-5 md:mx-16 lg:mb-16 lg:mt-9 lg:mx-24">
            <h3 class="text-gray-800 text-base md:text-xl font-semibold">Sabitlenmiş Konular</h3>
            <p class="text-xs md:text-sm text-normal text-gray-400 font-normal">
                Sabitlenen son 3 konu listelenmiştir. Muhtemelen önemli içeriğe sahipler.
            </p>
            <div class="mt-3 space-y-4">
                @forelse ($this->pinnedPosts as $post)
                    <div class="bg-white rounded-lg border-l-4 border-blue-500 shadow-sm hover:bg-blue-50 transition-all duration-300 cursor-pointer overflow-hidden group"
                        x-on:click="Livewire.navigate('{{ $post->showRoute() }}')"
                        wire:key="pinned-post-{{ $post->id }}">
                        <div class="p-3 md:p-4">
                            <div class="flex justify-between flex-col md:flex-row md:items-center">
                                <div class="flex items-center gap-2">
                                    <x-icons.pin class="text-blue-500 shrink-0" size="18" />
                                    <h4 style="word-break: break-word;"
                                        class="text-sm line-clamp-1 md:text-base font-semibold text-gray-800 group-hover:text-blue-700 transition-colors duration-300">
                                        {{ $post->title }}
                                    </h4>
                                </div>
                                <span class="text-xs text-gray-500 shrink-0">
                                    {{ $post->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <p style="word-break: break-word"
                                class="text-xs md:text-sm font-normal text-gray-500 mt-2 line-clamp-2">
                                {{ mb_substr(strip_tags($post->html), 0, 120, 'UTF-8') }}...
                            </p>

                            <div class="flex flex-col md:flex-row gap-3 justify-between md:items-center mt-3">
                                <div class="flex items-center gap-1 flex-wrap">
                                    @foreach ($post->tags as $tag)
                                        <x-link href="{{ route('tags.show', $tag->slug) }}"
                                            class="text-xs font-medium text-white bg-{{ $tag->color }}-500 px-2 py-0.5 rounded-full hover:no-underline hover:bg-gray-200 transition duration-300">
                                            {{ $tag->name }}
                                        </x-link>
                                    @endforeach
                                </div>

                                <div class="flex items-center gap-2">
                                    @if (!$post->isAnonim())
                                        <div class="flex items-center gap-1">
                                            <div
                                                class="size-5 md:size-6 shrink-0 rounded-full flex items-center justify-center">
                                                <img src="{{ $post->user->getAvatar() }}"
                                                    alt="{{ $post->user->name }}" class="size-full rounded-full" />
                                            </div>
                                            <span class="text-xs text-gray-600">{{ $post->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-600">Anonim</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-sm border-l-4 border-blue-200 px-4 py-5 text-center">
                        <div class="flex justify-center mb-3">
                            <x-icons.pin class="text-blue-300" size="20" />
                        </div>
                        <h4 class="text-sm font-semibold text-gray-800 mb-2">Sabitlenmiş Konu Bulunamadı</h4>
                        <p class="text-xs text-gray-600 max-w-md mx-auto">Şu anda sabitlenmiş bir konu
                            bulunmamaktadır.</p>
                        <div class="mt-3">
                            <x-link href="{{ route('posts.index') }}"
                                class="inline-flex items-center gap-1 text-blue-500 text-xs font-medium">
                                <x-icons.arrow-right-alt size="14" />
                                En Yeni Konuları Gör
                            </x-link>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>
        <section class="py-9 px-6 md:py-12 md:px-16 lg:py-16 lg:px-24 bg-gray-50">
            <div class="flex items-center justify-evenly gap-6 flex-wrap">
                <div
                    class="flex w-full xl:w-1/3 items-center px-7 py-5 gap-3.5 bg-white border border-gray-200 rounded-lg">
                    <div class="rounded bg-red-100 p-3">
                        <x-icons.school size="40" class="text-red-500" />
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
                    class="flex w-full xl:w-1/3 items-center px-7 py-5 gap-3.5 bg-white border border-gray-200 rounded-lg">
                    <div class="rounded bg-green-100 p-3">
                        <x-icons.game size="40" class="text-green-500" />
                    </div>
                    <div>
                        <h2 class="text-base md:text-lg font-semibold text-gray-700">
                            Oyun Merkezi
                        </h2>
                        <p class="text-xs md:text-sm text-gray-500">
                            Arkadaşlarınızla oyun oynayın ve eğlenin.
                        </p>
                    </div>
                </div>
                <div
                    class="flex w-full xl:w-1/3 items-center px-7 py-5 gap-3.5 bg-white border border-gray-200 rounded-lg">
                    <div class="rounded bg-blue-100 p-3">
                        <x-icons.options size="40" class="text-blue-500" />
                    </div>
                    <div>
                        <h2 class="text-base md:text-lg font-semibold text-gray-700">
                            Anketler
                        </h2>
                        <p class="text-xs md:text-sm text-gray-500">
                            Topluluk anketleri oluşturun ve fikir edinin.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-9 px-6 md:py-12 md:px-16 lg:py-16 lg:px-24">
            <div class="flex flex-col items-center justify-center text-center">
                <div class="p-3 md:p-4 lg:p-5 bg-blue-500 rounded-full mb-5">
                    <x-icons.game size="40" class="text-white" />
                </div>
                <h3 class="text-xl md:text-3xl font-semibold text-blue-900">Oyun Merkezi</h3>
                <p class="mt-2 md:mt-1.5 lg:mt-3 text-gray-600 text-sm md:text-lg font-normal w-full md:w-3/4">
                    Oyun merkezinde ister yan yana ister uzaktan arkadaşlarınızla oyun oynayabilirsiniz.
                </p>
                <x-link href="{{ route('games.index') }}"
                    class="text-blue-500 flex items-center justify-center gap-1 text-base md:text-lg font-medium mt-4">
                    Oyunları Keşfet
                    <x-icons.double-right size="20" />
                </x-link>
            </div>
            <div class="mt-6 md:mt-12 text-center">
                <p class="text-xs md:text-sm text-gray-800 font-light">
                    Bazı oyunlar şu anda yapım aşamasındadır.
                </p>
            </div>
        </section>
        @guest
            <section
                class="py-9 px-6 md:py-12 md:px-20 lg:py-16 lg:px-24 bg-gradient-to-b from-blue-500 to-blue-700 rounded-b-xl">
                <div class="text-center">
                    <h3 class="text-xl md:text-3xl font-semibold text-white">
                        Hemen Katılın ve Tartışmaya Başlayın
                    </h3>
                    <p class="text-sm md:text-lg font-normal text-teal-100 mt-2 mb-6 md:mb-10">
                        Gazi Social topluluğuna katılın, bilgi paylaşın ve yeni arkadaşlıklar kurun.
                    </p>
                    <x-link href="{{ route('register') }}"
                        class="text-blue-600 text-xs md:text-sm font-medium bg-blue-50 px-4 py-2.5 md:px-6 md:py-3.5 rounded-md hover:no-underline hover:bg-blue-100 transition duration-300">
                        Ücretsiz Hesap Oluştur
                    </x-link>
                </div>
            </section>
        @endguest
    </div>
</div>
