<div class="navbar">
    <div class="flex items-center gap-2">
        <x-link href='/'
            class="flex-1 flex items-center justify-start gap-2 mr-12 hover:no-underline hover:opacity-85"
            title="Ana Sayfa">
            <img src="{{ asset('gazi-logo.png') }}" alt="logo" class="size-10 md:size-14 object-cover">
            <span class="text-lg md:text-xl font-bold">Gazi
                Social</span>
        </x-link>
        <x-link href="/posts/create"
            class="hidden px-4 py-2 transition-all duration-200 md:inline-block bg-blue-200 bg-opacity-20 font-bold border-transparent text-sm text-blue-50 rounded-full hover:no-underline hover:bg-blue-500 hover:bg-opaity-100">
            Yeni Konu Oluştur
        </x-link>
        @can('join', App\Models\Faculty::class)
            <x-link href="/faculties"
                class="px-4 py-2 transition-all duration-200 bg-transparent text-sm text-white font-medium rounded-full hover:no-underline hover:bg-blue-200 hover:bg-opacity-30">Fakülteye
                Katıl</x-link>
        @endcan
    </div>
    <ul class="flex flex-1 space-x-4 items-center justify-end font-medium">

        @guest
            <div class="flex gap-2 justify-center items-center flex-row-reverse">
                <img src="https://generated.vusercontent.net/placeholder-user.jpg" alt="avatar"
                    class="size-12 md:size-14 object-cover rounded-full">
                <div class="flex flex-col gap-0 text-right">
                    <h4 class="text-sm font-bold">Misafir</h4>
                    <a href="/login" class="text-sm font-normal hover:underline">Giriş Yap</a>
                </div>
            </div>
        @endguest
        @auth
            <div class="flex gap-2 justify-center items-center flex-row-reverse">
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
                <div class="flex flex-col text-right">
                    <x-link href="/u/{{ Auth::user()->username }}"
                        class="text-xs md:text-sm font-medium">{{ Auth::user()->name }}</x-link>
                    <form method="POST" action="{{ route('logout') }}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs md:text-sm font-normal hover:text-red-500">Çıkış Yap</button>
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
