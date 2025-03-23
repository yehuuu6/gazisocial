<div x-data="{}" x-on:notification-updated.window="$wire.$refresh()" class="rounded-xl bg-white shadow-md p-6">
    <!-- Page Header -->
    <div class="mb-6 flex md:items-center md:justify-between flex-col md:flex-row gap-3">
        <h1 class="text-xl font-medium text-gray-800 flex items-center gap-2">
            <span class="inline-block p-1.5 bg-blue-50 rounded text-blue-600">
                <x-icons.notification size="20" />
            </span>
            Bildirimlerim
        </h1>
        <div class="flex items-center gap-2">
            <button wire:click="markAllAsRead"
                class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1.5">
                <x-icons.check-check size="16" />
                <span>Okundu İşaretle</span>
            </button>
            <button wire:click="deleteAllNotifications"
                wire:confirm="Tüm bildirimleri silmek istediğinize emin misiniz? Bu işlem geri alınamaz."
                class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1.5">
                <x-icons.trash size="16" />
                <span>Tümünü Sil</span>
            </button>
        </div>
    </div>

    <!-- Notifications List -->
    @forelse ($this->notifications as $notification)
        <div wire:key="notification-{{ $notification->id }}"
            class="bg-gray-50 border-l-4 {{ $notification->read ? 'border-gray-200' : 'border-blue-500' }} rounded mb-3 overflow-hidden shadow-sm">
            <div class="p-4 flex items-start gap-3">
                <!-- Icon -->
                <div class="size-10 rounded-full overflow-hidden">
                    <img src="{{ $this->getSenderAvatar($notification->data['sender_id']) }}"
                        alt="{{ $notification->user->name }}" class="w-full h-full object-cover">
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h3 class="{{ $notification->read ? 'text-gray-700' : 'text-blue-800' }} font-medium">
                                {{ $this->getNotificationTitle($notification->type) }}
                                @if (!$notification->read)
                                    <span
                                        class="ml-2 text-xs bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded">Yeni</span>
                                @endif
                            </h3>
                            <span class="text-gray-500 text-xs">
                                {{ $notification->created_at->locale('tr')->diffForHumans() }}
                            </span>
                        </div>
                    </div>

                    <!-- Message -->
                    <p class="text-gray-600 text-sm mb-3">
                        {{ $notification->data['text'] }}
                    </p>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 justify-end">
                        <button wire:click="deleteNotification({{ $notification->id }})"
                            wire:confirm="Bu bildirimi silmek istediğinize emin misiniz?"
                            class="text-xs text-gray-600 hover:text-red-600 flex items-center gap-1">
                            <x-icons.trash size="14" />
                            <span>Sil</span>
                        </button>

                        @if (isset($notification->data['action_url']))
                            <button wire:click="markAsRead({{ $notification->id }})"
                                class="text-xs text-gray-600 hover:text-blue-600 flex items-center gap-1">
                                <x-icons.eye size="14" />
                                <span>Görüntüle</span>
                            </button>
                        @endif

                        @if (!$notification->read)
                            <button wire:click="markAsRead({{ $notification->id }}, false)"
                                class="text-xs text-gray-600 hover:text-blue-600 flex items-center gap-1">
                                <x-icons.check size="14" />
                                <span>Okundu İşaretle</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <!-- Empty State -->
        <div class="bg-white rounded p-8 text-center shadow-sm">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-50 rounded-full mb-4">
                <x-icons.notification size="24" class="text-gray-400" />
            </div>
            <h3 class="text-base font-medium text-gray-800 mb-1">Bildiriminiz bulunmuyor</h3>
            <p class="text-sm text-gray-500 max-w-sm mx-auto">
                Gönderilere yorum yapıldığında veya yorumlarınıza yanıt verildiğinde bildirimleriniz burada
                görüntülenecektir.
            </p>
        </div>
    @endforelse

    <!-- Pagination -->
    @if ($this->notifications->hasPages())
        <div class="mt-4">
            {{ $this->notifications->links('livewire.pagination.profile') }}
        </div>
    @endif
</div>
