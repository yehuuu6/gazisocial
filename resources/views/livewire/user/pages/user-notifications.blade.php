<div class="bg-white rounded-xl shadow-md border border-gray-100">
    <div class="flex flex-col items-center justify-center gap-3 p-6">
        @forelse ($this->notifications as $notification)
            <button type="button"
                class="text-left hover:bg-gray-50 flex gap-2 w-full py-2 px-4 border border-gray-200 rounded-md"
                wire:key='notification-{{ $notification->id }}'>
                <div class="text-blue-600">
                    <x-icons.notification size="30" />
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex items-center justify-between w-full">
                        <h3 class="text-lg font-semibold text-blue-500">
                            {{ $this->getNotificationTitle($notification->type) }}
                        </h3>
                        <span class="text-xs text-gray-500 font-light">
                            {{ $notification->created_at->locale('tr')->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-base font-normal text-blue-400">
                        {{ $notification->data['text'] }}
                    </p>
                </div>
            </button>
        @empty
            <div class="flex items-center text-gray-500 justify-center gap-1.5 md:gap-2 px-1.5 py-3 md:px-3 md:py-5">
                <x-icons.sad size="24" />
                <span class="font-normal text-lg">Hiç bildirim yok</span>
            </div>
        @endforelse
    </div>
    {{ $this->notifications->links('livewire.pagination.simple') }}
</div>
