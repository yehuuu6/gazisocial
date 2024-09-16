<nav class="py-4 md:py-5 bg-white border-b border-gray-200 shadow-sm sticky bg-opacity-85 backdrop-blur top-0 z-10">
    <div class="flex items-center justify-between mx-[3%] md:mx-[6%] lg:mx-[12%]">
        <x-link href="/" class="hover:no-underline group flex hover:opacity-90 items-center gap-1.5 md:gap-2.5">
            <img src="{{ asset('gazi-logo.png') }}" alt="Gazi Social" class="size-10 md:size-12">
            <h1 class="text-lg font-semibold group-hover:opacity-90 md:text-2xl md:font-bold text-primary">
                Gazi Social
            </h1>
        </x-link>
        <button class="md:hidden flex items-center p-1 rounded-md hover:bg-gray-100" title="Menüyü Aç">
            <x-icons.menu size='30' color='black' />
        </button>
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
                    <div class="relative flex items-center group justify-center rounded-full overflow-hidden">
                        <div title="Profil resmini değiştir"
                            wire:click="$dispatch('openModal', { component: 'modals.update-avatar' })"
                            class="absolute size-full hidden group-hover:grid place-items-center bg-black bg-opacity-50 cursor-pointer">
                            <div id="update-avatar-nav">
                                <x-icons.image size='20' color='#f2f2f2' />
                            </div>
                        </div>
                        <img src="{{ Auth::user()->avatar }}" alt="avatar" class="size-10 object-cover md:size-12">
                    </div>
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
