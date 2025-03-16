<div x-data="{}" x-on:notification-updated.window="$wire.$refresh()">
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="p-6 flex items-center justify-between border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 p-2 rounded-lg">
                    <x-icons.notification size="24" class="text-blue-700" />
                </div>
                <h1 class="text-xl font-bold text-gray-800">Bildirimlerim</h1>
            </div>
            <div class="flex items-center gap-2">
                <button wire:click="markAllAsRead"
                    class="px-4 py-2 text-sm bg-primary hover:bg-opacity-90 text-white font-medium rounded-md flex items-center gap-2 transition-all duration-200 shadow-sm">
                    <x-icons.check-check size="18" />
                    Tümünü Okundu İşaretle
                </button>
                <button wire:click="deleteAllNotifications"
                    wire:confirm="Tüm bildirimleri silmek istediğinize emin misiniz? Bu işlem geri alınamaz."
                    class="px-4 py-2 text-sm bg-red-600 hover:bg-red-700 text-white font-medium rounded-md flex items-center gap-2 transition-all duration-200 shadow-sm">
                    <x-icons.trash size="18" />
                    Tümünü Sil
                </button>
            </div>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse ($this->notifications as $notification)
                <div wire:key="notification-{{ $notification->id }}"
                    class="p-4 md:p-6 {{ $notification->read ? 'bg-white' : 'bg-blue-50' }} transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div
                            class="{{ $notification->read ? 'bg-gray-100 text-gray-600' : 'bg-blue-100 text-blue-700' }} p-3 rounded-full flex-shrink-0 shadow-sm transition-all duration-300 {{ !$notification->read ? 'animate-pulse' : '' }}">
                            @if ($notification->type == 'post_comment')
                                <x-icons.new-comment size="24" />
                            @elseif ($notification->type == 'comment_reply')
                                <x-icons.new-reply size="24" />
                            @else
                                <x-icons.notification size="24" />
                            @endif
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center justify-between mb-2">
                                <h3
                                    class="{{ $notification->read ? 'text-gray-800' : 'text-blue-700' }} font-semibold text-base md:text-lg flex items-center gap-2">
                                    {{ $this->getNotificationTitle($notification->type) }}
                                    @if (!$notification->read)
                                        <span class="bg-primary text-white text-xs px-2 py-0.5 rounded-full">Yeni</span>
                                    @endif
                                </h3>
                                <span
                                    class="{{ $notification->read ? 'text-gray-500 border-gray-200 bg-gray-50' : 'text-primary border-primary/20 bg-primary/5' }} text-xs border px-2 py-1 rounded-full transition-colors">
                                    {{ $notification->created_at->locale('tr')->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm md:text-base mb-4 leading-relaxed">
                                {{ $notification->data['text'] }}
                            </p>
                            <div class="flex justify-between items-center">
                                <button wire:click="deleteNotification({{ $notification->id }})"
                                    wire:confirm="Bu bildirimi silmek istediğinize emin misiniz?"
                                    class="px-3 py-1.5 text-sm bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-md transition-all duration-200 shadow-sm flex items-center gap-1.5">
                                    <x-icons.trash size="16" />
                                    Sil
                                </button>
                                <div class="flex items-center gap-2">
                                    @if (isset($notification->data['action_url']))
                                        <button wire:click="markAsRead({{ $notification->id }})"
                                            class="px-3 py-1.5 text-sm bg-primary hover:bg-opacity-90 text-white font-medium rounded-md transition-all duration-200 shadow-sm flex items-center gap-1.5">
                                            <x-icons.eye size="16" />
                                            Görüntüle
                                        </button>
                                    @endif
                                    @if (!$notification->read)
                                        <button wire:click="markAsRead({{ $notification->id }}, false)"
                                            class="px-3 py-1.5 text-sm bg-primary/10 hover:bg-primary/20 text-primary font-medium rounded-md transition-all duration-200 shadow-sm flex items-center gap-1.5">
                                            <x-icons.check size="16" />
                                            Okundu İşaretle
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="bg-blue-100 p-6 rounded-full mb-6 shadow-inner">
                            <x-icons.notification size="48" class="text-blue-700" />
                        </div>
                        <h3 class="text-xl font-medium text-gray-700 mb-2">Hiç bildiriminiz yok</h3>
                        <p class="text-base text-gray-500 max-w-md">
                            Gönderilere yorum yapıldığında veya yorumlarınıza yanıt verildiğinde bildirimleriniz burada
                            görüntülenecektir.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
        @if ($this->notifications->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $this->notifications->links() }}
            </div>
        @endif
    </div>
</div>
