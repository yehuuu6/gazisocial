<div class="navbar">
    <div class="flex-1 flex items-center justify-start gap-2">
        <img src="{{ asset('gazi-logo.png') }}" alt="logo" class="size-10 md:size-14">
        <x-link href="/" class="text-lg md:text-xl font-bold hover:no-underline">Gazi
            Social</x-link>
    </div>
    <livewire:components.search-bar />
    </ul>
    <ul class="flex flex-1 space-x-4 items-center justify-end font-medium">
        @guest
            <div class="flex gap-2 justify-center items-center flex-row-reverse">
                <img src="https://generated.vusercontent.net/placeholder-user.jpg" alt="avatar"
                    class="w-12 h-12 rounded-full">
                <div class="flex flex-col gap-0 text-right">
                    <h4 class="text-sm font-bold">Misafir</h4>
                    <a href="/login" class="text-sm font-normal hover:underline">Giriş Yap</a>
                </div>
            </div>
        @endguest
        @auth
            <x-link href="/posts/create"
                class="hidden px-3 py-2 md:inline-block bg-blue-400 text-sm text-white rounded-full focus:outline-none hover:no-underline">Konu
                Oluştur</x-link>
            <div class="flex gap-2 justify-center items-center flex-row-reverse">
                <div class="relative flex items-center group justify-center rounded-full overflow-hidden">
                    <div title="Profil resmini değiştir"
                        wire:click="$dispatch('openModal', { component: 'modals.update-avatar' })"
                        class="absolute size-full hidden group-hover:grid place-items-center bg-black bg-opacity-50 cursor-pointer">
                        <x-icons.image size='20' color='#f2f2f2' />
                    </div>
                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="size-10 md:size-14">
                </div>
                <div class="flex flex-col text-right">
                    <x-link href="/u/{{ Auth::user()->username }}"
                        class="text-xs md:text-sm font-medium">{{ Auth::user()->name }}</x-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs md:text-sm font-normal hover:text-red-500">Çıkış Yap</button>
                    </form>
                </div>
            </div>
        @endauth
    </ul>
</div>
