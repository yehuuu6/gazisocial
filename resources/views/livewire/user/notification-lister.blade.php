<div x-anchor.offset.5.bottom-end="$refs.notificationMenu" x-transition.origin.top.right x-cloak
    x-show="notificationsDropdown" x-on:click.away="notificationsDropdown = false">
    <div class="bg-white rounded-md min-h-64 min-w-[350px] shadow-md border border-gray-200">
        <div class="flex items-center justify-between p-3">
            <h1 class="font-semibold text-base text-gray-700">Bildirimler</h1>
            <button x-on:click="notificationsDropdown = false"
                class="p-2 text-gray-700 text-xs flex items-center gap-1 font-medium rounded-md hover:bg-gray-100">
                <x-icons.cake size="20" />
                Tümünü okundu işaretle
            </button>
        </div>
        <x-seperator />
        <div class="w-full overflow-y-auto divide-y divide-gray-300">
            @forelse ($this->notifications as $notification)
                <div wire:key='notification-{{ $notification->id }}' class="flex items-center gap-3 p-3">
                    <div>
                        <x-icons.user size="30" class="text-gray-700" />
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <h3 class="font-medium text-sm text-gray-700">Arkadaşlık isteği</h3>
                            <span class="text-xs text-gray-500 font-light">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <div class="mt-1">
                            <p class="text-sm text-gray-500 font-normal">{{ $notification->data['message'] }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex items-center gap-3">
                    <h3 class="font-semibold">Bildirim Yok</h3>
                </div>
            @endforelse
            <x-link href="{{ route('home') }}"
                class="flex items-center justify-center gap-1 px-3 py-5 hover:bg-gray-100 hover:no-underline">
                <x-icons.notification size="20" class="text-blue-600" />
                <span class="font-medium text-sm text-gray-700">Tüm bildirimleri görüntüle</span>
            </x-link>
        </div>
    </div>
</div>
