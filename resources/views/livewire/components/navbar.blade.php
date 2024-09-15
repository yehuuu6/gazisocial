<div class="navbar">
    <div x-data="setupNavController()" class="flex flex-col md:flex-row md:items-center gap-2">
        <div class="flex justify-between items-center">
            <x-link href='/'
                class="flex-1 flex items-center justify-start gap-3 mr-12 hover:no-underline hover:opacity-85"
                title="Ana Sayfa">
                <img src="{{ asset('gazi-logo.png') }}" alt="logo" class="size-10 md:size-14 object-cover">
                <span class="text-lg md:text-xl font-bold">Gazi Social</span>
            </x-link>
            <div class="flex gap-3 items-center">
                <button title="Kategoriler" x-on:click="showCategories()"
                    class="p-1.5 cursor-pointer hover:bg-gray-50 hover:bg-opacity-15 rounded-md md:hidden">
                    <template x-if="categoriesOpen">
                        <x-icons.close size='24' color='white' />
                    </template>
                    <template x-if="!categoriesOpen">
                        <x-icons.hash size='24' color='white' />
                    </template>
                </button>
                <button title="Aktiviteler" x-on:click="showActivities()"
                    class="p-1.5 cursor-pointer hover:bg-gray-50 hover:bg-opacity-15 rounded-md md:hidden">
                    <template x-if="activityOpen">
                        <x-icons.close size='24' color='white' />
                    </template>
                    <template x-if="!activityOpen">
                        <x-icons.activity size='24' color='white' />
                    </template>
                </button>
                <button x-on:click="showMenuBar()" title="Menü"
                    class="p-1.5 cursor-pointer hover:bg-gray-50 hover:bg-opacity-15 rounded-md md:hidden">
                    <template x-if="menuOpen">
                        <x-icons.close size='24' color='white' />
                    </template>
                    <template x-if="!menuOpen">
                        <x-icons.menu size='24' color='white' />
                    </template>
                </button>
            </div>
        </div>
        <livewire:components.mobile-categories />
        <livewire:components.mobile-user-activities />
        <div id="responsive-menu"
            class="absolute top-[3.5rem] w-2/3 h-2/3 -right-2/3 md:p-0 md:w-auto md:h-auto md:rounded-none transition-all duration-100 p-2 rounded-b-lg bg-primary z-10 flex flex-col md:flex gap-2 md:static md:flex-row">
            <x-link href="/posts/create"
                class="px-4 py-2 md:pl-4 rounded transition-all bg-transparent duration-200 md:inline-block md:bg-blue-200 md:bg-opacity-20 font-medium border-transparent text-base md:text-sm text-blue-50 md:rounded-full hover:no-underline hover:bg-blue-200 hover:bg-opacity-30 md:hover:bg-blue-500 md:hover:bg-opacity-100">
                Yeni Konu Oluştur
            </x-link>
            @auth
                <x-link href="/faculties"
                    class="rounded px-4 py-2 md:pl-4 transition-all duration-200 bg-transparent text-base md:text-sm text-white font-medium md:rounded-full hover:no-underline hover:bg-blue-200 hover:bg-opacity-30">
                    Fakülteye Katıl
                </x-link>
            @endauth
            @guest
                <x-link href="/faculties"
                    class="rounded px-4 py-2 md:pl-4 transition-all duration-200 bg-transparent text-base md:text-sm text-white font-medium md:rounded-full hover:no-underline hover:bg-blue-200 hover:bg-opacity-30">
                    Fakülteleri Gör
                </x-link>
            @endguest
            <x-link href="/news"
                class="rounded px-4 py-2 md:pl-4 transition-all duration-200 bg-transparent text-base md:text-sm text-white font-medium md:rounded-full hover:no-underline hover:bg-blue-200 hover:bg-opacity-30">
                Haberler
            </x-link>
            <ul class="flex md:hidden items-center md:justify-end font-medium">
                @guest
                    <div
                        class="flex gap-2 bg-blue-200 rounded bg-opacity-30 py-2 px-4 justify-center items-center flex-grow md:flex-row-reverse">
                        <img src="https://generated.vusercontent.net/placeholder-user.jpg" alt="avatar"
                            class="size-12 md:size-14 object-cover rounded-full">
                        <div class="flex items-center justify-between flex-grow">
                            <h4 class="text-sm font-bold">Misafir</h4>
                            <a href="/login" title="Giriş Yap"
                                class="flex p-2 bg-transparent hover:bg-blue-100 rounded-full hover:bg-opacity-30 items-center justify-center">
                                <x-icons.login size='26' color='white' />
                            </a>
                        </div>
                    </div>
                @endguest
                @auth
                    <div
                        class="flex gap-2 bg-blue-200 rounded bg-opacity-30 py-2 px-4 justify-center items-center flex-grow md:flex-row-reverse">
                        <div class="relative flex items-center group justify-center rounded-full overflow-hidden">
                            <div title="Profil resmini değiştir"
                                wire:click="$dispatch('openModal', { component: 'modals.update-avatar' })"
                                class="absolute size-full hidden group-hover:grid place-items-center bg-black bg-opacity-50 cursor-pointer">
                                <div id="update-avatar-nav">
                                    <x-icons.image size='20' color='#f2f2f2' />
                                </div>
                            </div>
                            <img src="{{ Auth::user()->avatar }}" alt="avatar" class="size-10 object-cover md:size-14">
                        </div>
                        <div class="flex items-center justify-between flex-grow">
                            <x-link href="/u/{{ Auth::user()->username }}"
                                class="text-sm font-medium">{{ Auth::user()->name }}</x-link>
                            <form method="POST" action="{{ route('logout') }}" enctype="multipart/form-data">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Çıkış Yap"
                                    class="flex p-2 bg-transparent hover:bg-blue-100 rounded-full hover:bg-opacity-30 items-center justify-center text-sm font-normal hover:text-red-500">
                                    <x-icons.logout size='26' color='white' />
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </ul>
        </div>
    </div>
    <ul class="hidden md:flex flex-1 space-x-4 items-center md:justify-end font-medium">
        @guest
            <div class="flex gap-2 ml-3.5 md:ml-0 justify-center items-center md:flex-row-reverse">
                <img src="https://generated.vusercontent.net/placeholder-user.jpg" alt="avatar"
                    class="size-12 md:size-14 object-cover rounded-full">
                <div class="flex flex-col gap-0 text-right">
                    <h4 class="text-sm font-bold">Misafir</h4>
                    <a href="/login" class="text-sm font-normal hover:underline">Giriş Yap</a>
                </div>
            </div>
        @endguest
        @auth
            <div class="flex gap-2 justify-center items-center md:flex-row-reverse">
                <div class="relative flex items-center group justify-center rounded-full overflow-hidden">
                    <div title="Profil resmini değiştir"
                        wire:click="$dispatch('openModal', { component: 'modals.update-avatar' })"
                        class="absolute size-full hidden group-hover:grid place-items-center bg-black bg-opacity-50 cursor-pointer">
                        <div id="update-avatar-nav">
                            <x-icons.image size='20' color='#f2f2f2' />
                        </div>
                    </div>
                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="size-10 object-cover md:size-14">
                </div>
                <div class="flex flex-col md:text-right">
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
    </ul>
</div>

@script
    <script>
        const avatar = document.querySelector('#update-avatar-nav');
        Livewire.on('openModal', () => {
            avatar.classList.add('animate-bounce');
        });
        Livewire.on('closeModal', () => {
            avatar.classList.remove('animate-bounce');
        });
    </script>
@endscript
