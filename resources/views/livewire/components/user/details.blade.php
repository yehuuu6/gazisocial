@php
    if ($user->bio === null || empty($user->bio)) {
        $bio = 'Herhangi bir bilgi verilmemiş.';
    } else {
        $bio = $user->bio;
    }
    // Color variants
    $colorVariants = [
        'blue' => 'bg-blue-700',
        'red' => 'bg-red-700',
        'green' => 'bg-green-700',
    ];
@endphp
<div class="flex items-center gap-3 p-4">
    <div class="relative flex items-center group justify-center rounded-full overflow-hidden">
        @auth
            @if (Auth::user()->id === $user->id)
                <div title="Profil resmini değiştir"
                    wire:click="$dispatch('openModal', { component: 'modals.update-avatar' })"
                    class="absolute size-full hidden group-hover:grid place-items-center bg-black bg-opacity-50 cursor-pointer">
                    <div id="update-avatar-item">
                        <x-icons.image size='30' color='#f2f2f2' />
                    </div>
                </div>
            @endif
        @endauth
        <img src="{{ $user->avatar }}" alt="profil resmi" class="object-cover size-24">
    </div>
    <div class="flex flex-col gap-3 flex-1">
        <div class="flex items-center justify-between">
            <div class="flex gap-1 items-end">
                <h1 class="text-xl font-medium">{{ $user->name }}</h1>
                <div class="flex items-center gap-2">
                    <span class="text-gray-600 text-sm">{{ '@' . $user->username }}</span>
                    @forelse ($user->roles as $role)
                        <span
                            class="py-1 px-2 {{ $colorVariants[$role->color] }} text-white font-medium rounded-full capitalize text-xs">{{ $role->name }}</span>
                    @empty
                        <span
                            class="py-1 px-2 bg-orange-500 text-white font-medium rounded-full capitalize text-xs">Üye</span>
                    @endforelse
                </div>
            </div>
            @auth
                @if (Auth::user()->id === $user->id)
                    <x-link href="{{ route('user.edit', $user->username) }}" title="Profili Düzenle"
                        class="transition-transform duration-100 hover:no-underline hover:-translate-y-1">
                        <x-icons.settings color="#4b5563" size="25" />
                    </x-link>
                @endif
            @endauth
        </div>
        <p class="text-gray-600">{{ $bio }}</p>
        <div class="flex gap-3 items-center">
            @can('join', [App\Models\Faculty::class, $user])
                <div class="flex gap-1 items-center">
                    <x-icons.graduate color="#4b5563" size="24" />
                    <span class="text-gray-600 text-sm">{{ $user->faculty ?? 'Hemşirelik Fakültesi' }}</span>
                </div>
            @endcan
            <div class="flex items-center gap-1">
                <x-icons.trophy color="#4b5563" size="24" /><span class="text-sm text-gray-600">Seviye 10</span>
            </div>

            <div class="flex items-center gap-1">
                <x-icons.post color="#4b5563" size="24" />
                <span class="text-gray-600 text-sm">{{ $user->posts_count }} Gönderi</span>
            </div>
            <div class="flex items-center gap-1">
                <x-icons.comment color="#4b5563" size="24" />
                <span class="text-gray-600 text-sm">{{ $user->comments_count }} Yorum</span>
            </div>
            <div class="flex gap-1 items-center">
                <x-icons.calender color="#4b5563" size="24" />
                <span class="text-gray-600 text-sm">{{ $user->created_at->locale('tr')->translatedFormat('F Y') }}
                    tarihinde katıldı</span>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        const avatar = document.querySelector('#update-avatar-item');
        Livewire.on('openModal', () => {
            avatar.classList.add('animate-bounce');
        });
        Livewire.on('closeModal', () => {
            avatar.classList.remove('animate-bounce');
        });
    </script>
@endscript
