<div class="p-4" x-data="{ updateAvatarModal: false }">
    <div class="flex items-start md:items-center gap-3">
        @auth
            @if (Auth::user()->id === $user->id)
                <livewire:modals.update-avatar-modal :$user />
            @endif
        @endauth
        <x-users.avatar :size='24' :$user />
        <div class="flex flex-col gap-3 flex-1">
            <div class="flex items-center justify-between">
                <div class="flex gap-1 items-start md:items-end flex-col md:flex-row">
                    <h1 class="text-xl font-medium">{{ $user->name }}</h1>
                    <div class="flex gap-2 flex-col md:flex-row">
                        <span class="text-gray-600 text-sm">{{ '@' . $user->username }}</span>
                        <div class="flex gap-1 items-center flex-wrap">
                            @forelse ($user->roles as $role)
                                <span
                                    class="py-1 px-2 {{ $colorVariants[$role->color] }} text-white font-medium rounded-full capitalize text-xs">{{ $role->name }}</span>
                            @empty
                                <span
                                    class="py-1 px-2 bg-orange-500 text-white font-medium rounded-full capitalize text-xs">Üye</span>
                            @endforelse
                        </div>
                    </div>
                </div>
                @auth
                    @if (Auth::user()->id === $user->id)
                        <x-link href="{{ route('users.edit', $user->username) }}" title="Profili Düzenle"
                            class="hover:no-underline hover:bg-gray-100 rounded-full p-2 inline-block">
                            <x-icons.settings color="#4b5563" size="25" />
                        </x-link>
                    @endif
                @endauth
            </div>
            <div class='hidden md:flex flex-col gap-3'>
                <p class="text-gray-600">{{ $bio }}</p>
                <div class="flex gap-3 items-center flex-wrap">
                    <div class="flex gap-1 items-center">
                        <x-icons.graduate color="#4b5563" size="24" />
                        <span class="text-gray-600 text-sm">{{ $user->faculty ?? 'Hemşirelik Fakültesi' }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <x-icons.post color="#4b5563" size="24" />
                        <span class="text-gray-600 text-sm">{{ $user->posts_count }} Gönderi</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <x-icons.comment color="#4b5563" size="24" />
                        <span class="text-gray-600 text-sm">{{ $user->comments_count }} Yorum</span>
                    </div>
                    @if ($user->is_private)
                        <div class="flex gap-1 items-center">
                            <x-icons.lock color="#4b5563" size="24" />
                            <span class="text-gray-600 text-sm">Gizli Profil</span>
                        </div>
                    @endif
                    <div class="flex gap-1 items-center">
                        <x-icons.calender color="#4b5563" size="24" />
                        <span
                            class="text-gray-600 text-sm">{{ $user->created_at->locale('tr')->translatedFormat('F Y') }}
                            tarihinde katıldı</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='flex md:hidden flex-col gap-3 mt-4'>
        <p class="text-gray-600">{{ $bio }}</p>
        <div class="flex gap-3 items-center flex-wrap md:flex-nowrap">
            <div class="flex gap-1 items-center">
                <x-icons.graduate color="#4b5563" size="24" />
                <span class="text-gray-600 text-sm">{{ $user->faculty ?? 'Hemşirelik Fakültesi' }}</span>
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
            @if ($user->is_private)
                <div class="flex gap-1 items-center">
                    <x-icons.lock color="#4b5563" size="24" />
                    <span class="text-gray-600 text-sm">Gizli Profil</span>
                </div>
            @endif
        </div>
    </div>
</div>
