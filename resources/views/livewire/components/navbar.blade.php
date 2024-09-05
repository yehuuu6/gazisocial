<div class="navbar">
    <div class="flex-1 flex items-center justify-start gap-2">
        <img src="{{ asset('gazi-logo.png') }}" alt="logo" class="w-14 h-14">
        <x-link href="/" class="text-xl font-bold hover:no-underline">Gazi Social</x-link>
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
                class="px-3 py-2 bg-blue-400 text-sm text-white rounded-full focus:outline-none hover:no-underline">Konu
                Oluştur</x-link>
            <div class="flex gap-2 justify-center items-center flex-row-reverse">
                <img src="{{ Auth::user()->avatar }}" alt="avatar" class="w-12 h-12 rounded-full">
                <div class="flex flex-col gap-0 text-right">
                    <x-link href="/u/{{ Auth::user()->username }}"
                        class="text-sm font-medium">{{ Auth::user()->name }}</x-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm font-normal hover:text-red-500">Çıkış Yap</button>
                    </form>
                </div>
            </div>
        @endauth
    </ul>
</div>
