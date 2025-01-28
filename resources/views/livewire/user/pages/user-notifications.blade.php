<div class="bg-white rounded-xl shadow-md border border-gray-100">
    <div class="flex flex-col items-center justify-center gap-3 p-6">
        <div class="flex gap-2 flex-row-reverse">
            <div class="w-64 border border-gray-200 rounded-md sticky top-0"></div>
            <div class="divide-y divide-gray-200 w-full">
                @forelse ($this->notifications as $notification)
                    <div class="flex gap-10 w-full py-4 px-2 hover:bg-gray-50 cursor-pointer">
                        <x-icons.notification size="30" class="text-gray-400" />
                        <div class="flex flex-col gap-2 w-full">
                            <div class="flex items-center justify-between">
                                <span class="mt-1 px-2 py-1 text-white bg-green-600 font-medium text-xs rounded">
                                    Yorum
                                </span>
                                <span class="text-xs text-gray-500 font-light">
                                    <x-icons.time size="16" class="text-gray-400 inline-block mr-2" />
                                    {{ $notification->created_at->locale('tr')->diffForHumans() }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-sm text-gray-700 font-medium">
                                    {{ $this->getNotificationTitle($notification->type) }}
                                </h3>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-light">
                                    {{ $notification->data['text'] }}
                                </p>
                            </div>
                            <div>
                                <button wire:click="markAsRead({{ $notification->id }})"
                                    class="text-xs text-blue-600 font-medium hover:underline">
                                    Okundu olarak işaretle
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="flex items-center text-gray-500 justify-center gap-1.5 md:gap-2 px-1.5 py-3 md:px-3 md:py-5">
                        <x-icons.sad size="24" />
                        <span class="font-normal text-lg">Hiç bildirim yok</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    {{ $this->notifications->links('livewire.pagination.simple') }}
</div>
