<div class="p-4" x-data="{ updateAvatarModal: false }">
    <div class="flex items-start gap-3 md:items-center">
        @auth
            @if (Auth::user()->id === $user->id)
                <livewire:modals.update-avatar-modal :$user />
            @endif
        @endauth
        <x-users.avatar :size='24' :$user />
        <div class="flex flex-1 flex-col gap-3">
            <div class="flex items-center justify-between">
                <div class="flex flex-col items-start gap-1 md:flex-row md:items-end">
                    <h1 class="text-xl font-medium">{{ $user->name }}</h1>
                    <div class="flex flex-col gap-2 md:flex-row">
                        <span class="text-sm text-gray-600">{{ '@' . $user->username }}</span>
                        <div class="flex flex-wrap items-center gap-1">
                            @forelse ($user->roles as $role)
                                <span
                                    class="{{ $colorVariants[$role->color] }} rounded-full px-2 py-1 text-xs font-medium capitalize text-white">{{ $role->name }}</span>
                            @empty
                                <span
                                    class="rounded-full bg-orange-500 px-2 py-1 text-xs font-medium capitalize text-white">Üye</span>
                            @endforelse
                        </div>
                    </div>
                </div>
                @auth
                    @if (Auth::user()->id === $user->id)
                        <x-link href="{{ route('users.edit', $user->username) }}" title="Profili Düzenle"
                            class="inline-block rounded-full p-2 hover:bg-gray-100 hover:no-underline">
                            <x-icons.settings color="#4b5563" size="25" />
                        </x-link>
                    @endif
                @endauth
            </div>
            <div class='hidden flex-col gap-3 md:flex'>
                <p class="text-gray-600">{{ $bio }}</p>
                <div class="flex flex-wrap items-center gap-3">
                    @if ($user->faculty)
                        <div class="flex items-center gap-1">
                            <x-icons.graduate color="#4b5563" size="24" />
                            <span class="text-sm text-gray-600">{{ $user->faculty->name }}</span>
                        </div>
                    @endif
                    <div class="flex items-center gap-1">
                        <x-icons.post color="#4b5563" size="24" />
                        <span class="text-sm text-gray-600">{{ $user->posts_count }} Gönderi</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <x-icons.comment color="#4b5563" size="24" />
                        <span class="text-sm text-gray-600">{{ $user->getCommentsCount() }} Yorum & Yanıt</span>
                    </div>
                    @if ($user->is_private)
                        <div class="flex items-center gap-1">
                            <x-icons.lock color="#4b5563" size="24" />
                            <span class="text-sm text-gray-600">Gizli Profil</span>
                        </div>
                    @endif
                    <div class="flex items-center gap-1">
                        <x-icons.calender color="#4b5563" size="24" />
                        <span
                            class="text-sm text-gray-600">{{ $user->created_at->locale('tr')->translatedFormat('F Y') }}
                            tarihinde katıldı</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='mt-4 flex flex-col gap-3 md:hidden'>
        <p class="text-gray-600">{{ $bio }}</p>
        <div class="flex flex-wrap items-center gap-3 md:flex-nowrap">
            @can('have', $user->faculty, $user)
                <div class="flex items-center gap-1">
                    <x-icons.graduate color="#4b5563" size="24" />
                    <span class="text-sm text-gray-600">{{ $user->faculty->name }}</span>
                </div>
            @endcan
            <div class="flex items-center gap-1">
                <x-icons.post color="#4b5563" size="24" />
                <span class="text-sm text-gray-600">{{ $user->posts_count }} Gönderi</span>
            </div>
            <div class="flex items-center gap-1">
                <x-icons.comment color="#4b5563" size="24" />
                <span class="text-sm text-gray-600">{{ $user->comments_count }} Yorum</span>
            </div>
            <div class="flex items-center gap-1">
                <x-icons.calender color="#4b5563" size="24" />
                <span class="text-sm text-gray-600">{{ $user->created_at->locale('tr')->translatedFormat('F Y') }}
                    tarihinde katıldı</span>
            </div>
            @if ($user->is_private)
                <div class="flex items-center gap-1">
                    <x-icons.lock color="#4b5563" size="24" />
                    <span class="text-sm text-gray-600">Gizli Profil</span>
                </div>
            @endif
        </div>
    </div>
</div>
