<div x-data="{
    notificationsDropdown: false,
    hasUnreadNotifications: $wire.entangle('hasUnreadNotifications'),
}" class="flex items-center gap-2 text-primary">
    <button x-on:click="notificationsDropdown = !notificationsDropdown" x-ref="notificationMenu"
        class="p-2 hover:bg-gray-100 rounded-md relative">
        <div x-cloak x-show="hasUnreadNotifications">
            <span class="absolute size-2.5 top-2 right-2 animate-ping bg-blue-500 rounded-full text-xs font-semibold">
            </span>
            <span class="absolute size-2.5 top-2 right-2 bg-blue-500 rounded-full text-xs font-semibold">
            </span>
        </div>
        <div :class="{ 'animate-wiggle': hasUnreadNotifications }">
            <x-icons.notification size="33" />
        </div>
    </button>
    <div x-anchor.offset.5.bottom-end="$refs.notificationMenu" x-transition.origin.top.right x-cloak
        x-show="notificationsDropdown" x-on:click.away="notificationsDropdown = false">
        <div class="bg-white rounded-md w-72 md:w-96 shadow-md border border-gray-200">
            <div class="flex items-center justify-between p-3">
                <h1 class="font-semibold text-sm md:text-base text-gray-800">Bildirimler</h1>
                <button
                    x-on:click="hasUnreadNotifications = false; notificationsDropdown = false; $dispatch('notification-all-read')"
                    wire:click="markAllAsRead"
                    class="p-2 text-gray-800 text-xs flex items-center gap-1 md:gap-3 font-medium rounded-md hover:bg-gray-100">
                    <x-icons.check-check size="18" class="text-blue-600" />
                    Tümünü okundu işaretle
                </button>
            </div>
            <x-seperator />
            <div class="flex flex-col max-h-52 md:max-h-64 overflow-y-auto divide-y divide-gray-300 select-none">
                @forelse ($this->notifications as $notification)
                    <button x-data="{
                        isRead: {{ $notification->read ? 'true' : 'false' }},
                    }" x-on:notification-all-read.window="isRead = true"
                        wire:click="markAsRead({{ $notification->id }})"
                        x-on:click="isRead = true; notificationsDropdown = false"
                        wire:key='notification-{{ $notification->id }}'
                        :class="{ 'bg-white hover:bg-gray-100': isRead, 'bg-blue-50 hover:bg-blue-100': !isRead }"
                        class="flex text-left items-center gap-1.5 md:gap-3 p-1.5 md:p-3 cursor-pointer">
                        <div :class="{
                            'bg-blue-100 text-blue-600': !isRead,
                            'bg-gray-100 text-gray-600': isRead
                        }"
                            class="p-1.5 md:p-2 rounded-full">
                            @if ($notification->type == 'friend_request')
                                <x-icons.user-plus size="18" />
                            @elseif ($notification->type == 'friend_accept')
                                <x-icons.user-check size="18" />
                            @elseif ($notification->type == 'post_comment')
                                <x-icons.new-comment size="18" />
                            @elseif ($notification->type == 'comment_reply')
                                <x-icons.new-reply size="18" />
                            @else
                                <x-icons.notification size="18" />
                            @endif
                        </div>
                        <div class="w-full">
                            <div class="flex items-center justify-between">
                                <h3 :class="{ 'font-semibold text-blue-600': !isRead, 'font-medium text-gray-700': isRead }"
                                    class="text-xs md:text-sm">
                                    {{ $this->getNotificationTitle($notification->type) }}</h3>
                                <span class="text-xs text-gray-500 font-light">
                                    {{ $notification->created_at->locale('tr')->diffForHumans() }}
                                </span>
                            </div>
                            <div class="mt-1">
                                <p class="text-xs md:text-sm text-gray-600 font-light">{{ $notification->data['text'] }}
                                </p>
                            </div>
                        </div>
                    </button>
                @empty
                    <div
                        class="flex items-center text-gray-500 justify-center gap-1.5 md:gap-2 px-1.5 py-3 md:px-3 md:py-5">
                        <x-icons.sad size="18" />
                        <span class="font-light text-xs md:text-sm">Hiç bildirim yok</span>
                    </div>
                @endforelse
            </div>
            @if ($this->notifications->isNotEmpty())
                <x-seperator />
                <x-link href="{{ route('home') }}"
                    class="flex items-center justify-center gap-1.5 md:gap-2 px-1.5 py-3 md:px-3 md:py-5 hover:bg-gray-100 hover:no-underline">
                    <x-icons.notification size="18" class="text-blue-600" />
                    <span class="font-medium text-xs md:text-sm text-gray-700">Tüm bildirimleri görüntüle</span>
                </x-link>
            @endif
        </div>
    </div>
</div>
