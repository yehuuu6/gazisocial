<nav x-data="{ open: false }"
    class="bg-opacity-85 sticky top-0 !z-20 border-b border-gray-200 bg-white py-4 shadow-sm backdrop-blur md:py-5">
    <div class="relative mx-[3%] flex items-center justify-between md:mx-[6%] lg:mx-[12%]">
        <x-link href="/" class="group flex items-center gap-1.5 hover:no-underline hover:opacity-90 md:gap-2.5">
            <img src="{{ asset('gazi-logo.png') }}" alt="Gazi Social" class="size-10 md:size-12">
            <h1 class="text-lg font-semibold text-primary group-hover:opacity-90 md:text-2xl md:font-bold">
                Gazi Social
            </h1>
        </x-link>
        <button @click="open = !open" class="flex items-center rounded-md p-1 hover:bg-gray-100 md:hidden"
            title="Menüyü Aç">
            <template x-if="open">
                <x-icons.close size='30' color='rgb(11, 62, 117)' />
            </template>
            <template x-if="!open">
                <x-icons.menu size='30' color='rgb(11, 62, 117)' />
            </template>
        </button>
        <div x-cloak x-show='open' @click.away="open = false" x-collapse
            class="absolute top-14 flex w-full flex-col gap-2 rounded-b-lg bg-white bg-opacity-95 p-2 shadow-md md:hidden">
            <x-link href="/posts/pinned"
                class="rounded px-3 py-2 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                Yeni Konu Oluştur
            </x-link>
            <x-link href="/posts/pinned"
                class="rounded px-3 py-2 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                Sabitlenmiş Konular
            </x-link>
            @guest
                <x-link href="{{ route('login') }}"
                    class="rounded px-3 py-2 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                    Giriş Yap
                </x-link>
                <x-link href="{{ route('register') }}"
                    class="rounded px-3 py-2 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                    Kayıt Ol
                </x-link>
            @endguest
            @auth
                @can('join', App\Models\Faculty::class)
                    @if (!Auth::user()->faculty)
                        <x-link href="/faculties"
                            class="rounded px-3 py-2 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                            Fakülteye Katıl
                        </x-link>
                    @endif
                @endcan
                <x-link href="/u/{{ Auth::user()->username }}"
                    class="flex flex-row-reverse items-center justify-between gap-1 rounded px-3 py-2 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="size-6 rounded-full object-cover">
                    <span>{{ Auth::user()->name }}</span>
                </x-link>
                <form method="POST" action="{{ route('logout') }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex w-full items-center justify-between rounded px-3 py-2 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                        <span>Çıkış Yap</span>
                        <x-icons.logout size='20' color='rgb(11, 62, 117)' />
                    </button>
                </form>
            @endauth
        </div>
        <div class="hidden md:block">
            @guest
                <div class="flex items-center gap-1.5 md:gap-3">
                    <a href="{{ route('login') }}"
                        class="rounded-full border border-primary bg-opacity-100 px-2.5 py-1.5 text-xs text-primary transition-all duration-100 hover:bg-primary hover:bg-opacity-100 hover:text-white hover:no-underline md:px-4 md:py-2 md:text-sm">
                        Giriş Yap
                    </a>
                    <a href="{{ route('register') }}"
                        class="rounded-full bg-primary bg-opacity-100 px-2.5 py-1.5 text-xs text-white transition-all duration-100 hover:bg-opacity-90 hover:no-underline md:px-4 md:py-2 md:text-sm">
                        Kayıt Ol
                    </a>
                </div>
            @endguest
            @auth
                <div x-data="{ open: false }">
                    <div @click="open = !open" x-ref="userMenu"
                        class="bg-opacity-85 flex cursor-pointer items-center justify-center gap-1 rounded-lg p-2 hover:bg-gray-100 hover:backdrop-blur">
                        <img src="{{ Auth::user()->avatar }}" alt="profil resmi" class="size-9 rounded-full object-cover">
                        <div class="ml-1 flex flex-col">
                            <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                            <span class="text-xs font-light text-gray-500">{{ '@' . Auth::user()->username }}</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="size-5 ml-0.5" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                        </svg>
                    </div>
                    <div class="flex w-[225px] max-w-lg flex-col gap-1 rounded-md border border-gray-200 bg-white text-sm text-gray-800 shadow-lg"
                        x-anchor.offset.5.bottom-end="$refs.userMenu" x-cloak x-show="open" @click.away="open = false"
                        x-transition.scale.origin.top>
                        <h3 class="px-3 py-2 font-semibold">Hesabım</h3>
                        <x-seperator />
                        <x-link href="/u/{{ Auth::user()->username }}"
                            class="mx-1 flex items-center gap-1.5 rounded px-3 py-2 hover:bg-gray-100 hover:no-underline">
                            <x-icons.user size='17' color="#131313" />
                            <span>Profili Gör</span>
                        </x-link>
                        <x-link href="{{ route('users.edit', Auth::user()->username) }}"
                            class="mx-1 flex items-center gap-1.5 rounded px-3 py-2 hover:bg-gray-100 hover:no-underline">
                            <x-icons.cog size='17' color="#131313" />
                            <span>Ayarlar</span>
                        </x-link>
                        <a href="https://github.com/yehuuu6/gazisocial" target="_blank"
                            class="mx-1 flex items-center justify-between gap-1.5 rounded px-3 py-2 hover:bg-gray-100 hover:no-underline">
                            <div class="5 flex items-center gap-1">
                                <x-icons.social.github-regular size='17' color="#131313" />
                                <span>GitHub Repo</span>
                            </div>
                            <x-icons.star size='17' color="#ffe600" fill="#ffe600" />
                        </a>
                        <x-seperator />
                        <form method="POST" action="{{ route('logout') }}"
                            class="mx-1 mb-1 cursor-pointer rounded px-2 py-2 hover:bg-gray-100">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="mx-1 flex w-full items-center gap-1.5 rounded hover:no-underline">
                                <x-icons.logout size='17' color="#131313" />
                                <span>Çıkış Yap</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
