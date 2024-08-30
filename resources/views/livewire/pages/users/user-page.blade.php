<div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden">
    <x-header-title>
        Kullanıcı Profili
    </x-header-title>
    <x-seperator />
    <div class="relative h-full">
        <div class="absolute overflow-y-auto overflow-x-hidden h-full w-full">
            <div class="flex gap-3 p-4">
                <img class="rounded-full size-14" src="{{ asset($user->avatar) }}" alt="profile picture">
                <div class="flex flex-col gap-3 flex-1">
                    <div class="flex items-center justify-between">
                        <div class="flex gap-2 items-end">
                            <h1 class="text-xl font-bold">{{ $user->name }}</h1>
                            <div class="space-x-1">
                                <span class="text-gray-500 text-sm">{{ '@' . $user->username }}</span>
                                <span
                                    class="py-2 px-4 bg-red-700 text-white font-medium rounded-full text-xs">Yönetici</span>
                                @if ($user->is_gazi)
                                    <span
                                        class="py-2 px-4 bg-blue-700 text-white font-medium rounded-full text-xs">Gazili</span>
                                @endif
                            </div>
                        </div>
                        <x-icons.settings />
                    </div>
                    <p class="text-gray-500">{{ $user->bio }}</p>
                    <div class="flex gap-3 items-center">
                        <div class="flex gap-1 items-center">
                            <x-icons.calender />
                            <span class="text-gray-500">{{ $user->created_at->translatedFormat('F Y') }}
                                tarihinden beri</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <x-icons.trophy /><span class="text-gray-500">Seviye 10</span>
                        </div>

                        <div class="flex items-center gap-1">
                            <x-icons.post />
                            <span class="text-gray-500">{{ $user->posts->count() }} Gönderi</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <x-icons.comment-count />
                            <span class="text-gray-500">{{ $user->comments->count() }} Yorum</span>
                        </div>
                    </div>
                </div>
            </div>
            <x-seperator />
            <h3 id="comment-header" class="p-4 text-xl font-bold">Son Aktiviteler</h3>
            <ul wire:loading.remove class="flex flex-1 flex-col gap-1 pb-5">
                <li class="p-4 text-gray-500">Henüz aktivite yok!</li>
            </ul>
        </div>
    </div>
</div>
