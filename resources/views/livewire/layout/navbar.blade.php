<nav x-data="{ navbarDropdown: false }" id="navbar"
    class="bg-opacity-85 sticky top-0 z-30 border-b border-gray-200 bg-white py-4 shadow-sm backdrop-blur md:py-5">
    <div class="relative" x-ref="navbar">
        <div class="flex items-center justify-between mx-[3%] md:mx-[6%] lg:mx-[12%]">
            <x-link href="/" class="group flex items-center gap-1.5 hover:no-underline hover:opacity-90 md:gap-2.5">
                <div class="h-12">
                    <img src="{{ asset('logos/GS_LOGO_DEFAULT.png') }}" alt="Gazi Social Logo"
                        class="object-contain h-full w-full">
                </div>
            </x-link>
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
                    <div class="flex items-center gap-3 p-2">
                        <div class="flex items-center gap-2 text-primary">
                            <button x-on:click="alert('Not implemented yet!');"
                                class="p-2 hover:bg-gray-100 rounded-md relative">
                                <span
                                    class="absolute size-2.5 top-2 right-2 animate-ping bg-blue-500 rounded-full text-xs font-semibold">
                                </span>
                                <span
                                    class="absolute size-2.5 top-2 right-2 bg-blue-500 rounded-full text-xs font-semibold">
                                </span>
                                <x-icons.notification size="33" />
                            </button>
                        </div>
                        <div x-data="{ userDropdown: false }">
                            <div x-on:click="userDropdown = !userDropdown" x-ref="userMenu"
                                class="flex cursor-pointer items-center justify-center gap-1 rounded-lg p-2 hover:bg-gray-100">
                                <img src="{{ Auth::user()->avatar }}" alt="profil resmi"
                                    class="size-9 rounded-full object-cover">
                                <div class="ml-1 flex flex-col">
                                    <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                                    <span class="text-xs font-light text-gray-500">{{ '@' . Auth::user()->username }}</span>
                                </div>
                                <div class="ml-0.5">
                                    <x-icons.arrow-up-down size="20" />
                                </div>
                            </div>
                            <div class="flex w-[225px] max-w-lg flex-col gap-1 rounded-md border border-gray-200 bg-white text-sm text-gray-800 shadow-lg"
                                x-anchor.offset.5.bottom-end="$refs.userMenu" x-cloak x-show="userDropdown"
                                x-on:click.away="userDropdown = false" x-transition.scale.origin.top>
                                <h3 class="px-3 py-2 font-semibold">Hesabım</h3>
                                <x-seperator />
                                <x-link href="{{ route('users.show', Auth::user()->username) }}"
                                    class="mx-1 flex items-center gap-3 rounded px-3 py-2 hover:bg-gray-100 hover:no-underline">
                                    <x-icons.user size="20" />
                                    <span>Profili Gör</span>
                                </x-link>
                                <x-link href="{{ route('users.edit', Auth::user()->username) }}"
                                    class="mx-1 flex items-center gap-3 rounded px-3 py-2 hover:bg-gray-100 hover:no-underline">
                                    <x-icons.cog size="20" />
                                    <span>Ayarlar</span>
                                </x-link>
                                <a href="https://github.com/yehuuu6/gazisocial" target="_blank"
                                    class="mx-1 flex items-center justify-between gap-3 rounded px-3 py-2 hover:bg-gray-100 hover:no-underline">
                                    <div class="flex items-center gap-3">
                                        <x-icons.github size="20" />
                                        <span>GitHub Repo</span>
                                    </div>
                                    <div class="text-yellow-400">
                                        <x-icons.star size="20" />
                                    </div>
                                </a>
                                <x-seperator />
                                <form method="POST" action="{{ route('logout') }}" class="flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="mx-1 flex-1 mb-1 flex items-center gap-3.5 rounded px-3 py-2 hover:bg-gray-100 hover:no-underline">
                                        <x-icons.logout size="16" />
                                        <span>Çıkış Yap</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
            <div class="flex items-center justify-end gap-3 text-primary-600 text-primary md:hidden">
                <button x-on:click="alert('Not implemented yet!');" class="p-1 hover:bg-gray-100 rounded-md relative">
                    <span
                        class="absolute size-2.5 top-2 right-2 animate-ping bg-blue-500 rounded-full text-xs font-semibold">
                    </span>
                    <span class="absolute size-2.5 top-2 right-2 bg-blue-500 rounded-full text-xs font-semibold">
                    </span>
                    <x-icons.notification size="36" />
                </button>
                <button x-on:click="navbarDropdown = !navbarDropdown"
                    class="flex items-center rounded-md p-1 hover:bg-gray-100" title="Menüyü Aç">
                    <template x-if="navbarDropdown">
                        <x-icons.close size="36" />
                    </template>
                    <template x-if="!navbarDropdown">
                        <x-icons.menu size="36" />
                    </template>
                </button>
            </div>
        </div>
        <div x-anchor.offset.17.no-style="$refs.navbar"
            :style="{ position: 'absolute', top: $anchor.y + 'px', left: '0px' }" x-cloak x-show='navbarDropdown'
            x-on:click.away="navbarDropdown = false" x-collapse class="w-full bg-white shadow-md md:hidden">
            <x-link href="{{ route('posts.create') }}"
                class="flex rounded px-6 py-4 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                Yeni Konu Oluştur
            </x-link>
            @guest
                <x-link href="{{ route('login') }}"
                    class="flex rounded px-6 py-4 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                    Giriş Yap
                </x-link>
                <x-link href="{{ route('register') }}"
                    class="flex rounded px-6 py-4 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                    Kayıt Ol
                </x-link>
            @endguest
            @auth
                @can('join', App\Models\Faculty::class)
                    @if (!Auth::user()->faculty)
                        <x-link href="{{ route('faculties') }}"
                            class="flex rounded px-6 py-4 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                            Fakülteye Katıl
                        </x-link>
                    @endif
                @endcan
                <x-link href="{{ route('users.show', Auth::user()->username) }}"
                    class="flex flex-row-reverse items-center justify-between gap-1 rounded px-6 py-4 text-sm font-medium text-primary hover:bg-gray-100 hover:no-underline">
                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="size-6 rounded-full object-cover">
                    <span>{{ Auth::user()->name }}</span>
                </x-link>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex w-full items-center justify-between gap-1 rounded px-6 py-4 text-sm font-medium text-primary hover:bg-gray-100">
                        <span>Çıkış Yap</span>
                        <x-icons.logout size="20" class="mr-1" />
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>
