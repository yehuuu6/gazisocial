<nav x-data="{ open: false }"
    class="py-4 md:py-5 bg-white border-b border-gray-200 shadow-sm sticky bg-opacity-85 backdrop-blur top-0 z-50">
    <div class="relative flex items-center justify-between mx-[3%] md:mx-[6%] lg:mx-[12%]">
        <x-link href="/" class="hover:no-underline group flex hover:opacity-90 items-center gap-1.5 md:gap-2.5">
            <img src="{{ asset('gazi-logo.png') }}" alt="Gazi Social" class="size-10 md:size-12">
            <h1 class="text-lg font-semibold group-hover:opacity-90 md:text-2xl md:font-bold text-primary">
                Gazi Social
            </h1>
        </x-link>
        <button @click="open = !open" class="md:hidden flex items-center p-1 rounded-md hover:bg-gray-100"
            title="Menüyü Aç">
            <x-icons.menu size='30' color='black' />
        </button>
        <div x-cloak x-show='open' @click.away="open = false" x-transition.duration.250ms
            class="absolute bg-white w-full rounded-b-lg shadow-md top-14 p-2 bg-opacity-95 flex md:hidden flex-col gap-2">
            <x-link href="/posts/create"
                class="py-2 px-3 text-primary text-sm font-medium rounded hover:bg-gray-100 hover:no-underline">
                Yeni Konu Oluştur
            </x-link>
            <x-link href="/faculties"
                class="py-2 px-3 text-primary text-sm font-medium rounded hover:bg-gray-100 hover:no-underline">
                Fakülteye Katıl
            </x-link>
            @guest
                <x-link href="{{ route('login') }}"
                    class="py-2 px-3 text-primary text-sm font-medium rounded hover:bg-gray-100 hover:no-underline">
                    Giriş Yap
                </x-link>
                <x-link href="{{ route('register') }}"
                    class="py-2 px-3 text-primary text-sm font-medium rounded hover:bg-gray-100 hover:no-underline">
                    Kayıt Ol
                </x-link>
            @endguest
            @auth
                <x-link href="/u/{{ Auth::user()->username }}"
                    class="py-2 px-3 text-primary flex flex-row-reverse justify-between items-center gap-1 text-sm font-medium rounded hover:bg-gray-100 hover:no-underline">
                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="size-6 object-cover rounded-full">
                    <span>{{ Auth::user()->name }}</span>
                </x-link>
                <form method="POST" action="{{ route('logout') }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="py-2 px-3 flex items-center w-full justify-between text-primary text-sm font-medium rounded hover:bg-gray-100 hover:no-underline">
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
                        class="text-primary rounded-full border transition-all duration-100 border-primary px-2.5 py-1.5 md:px-4 md:py-2 text-xs md:text-sm bg-opacity-100 hover:no-underline hover:text-white hover:bg-primary hover:bg-opacity-100">
                        Giriş Yap
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-primary text-xs md:text-sm transition-all duration-100 text-white rounded-full px-2.5 py-1.5 md:px-4 md:py-2 hover:no-underline bg-opacity-100 hover:bg-opacity-90">
                        Kayıt Ol
                    </a>
                </div>
            @endguest
            @auth
                <div class="md:flex gap-1 md:gap-2 justify-center items-center flex-row-reverse">
                    <x-users.avatar :size='12' :user='Auth::user()' iconSize='20' />
                    <div class="flex flex-col text-right">
                        <x-link href="/u/{{ Auth::user()->username }}"
                            class="text-xs md:text-sm font-medium">{{ Auth::user()->name }}</x-link>
                        <form method="POST" action="{{ route('logout') }}" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs md:text-sm font-normal hover:text-red-500">Çıkış
                                Yap</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
