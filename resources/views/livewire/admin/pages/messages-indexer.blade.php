<div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
    <div class="flex items-center justify-between m-6 mb-0">
        <h1 class="text-3xl font-bold text-gray-900">Gönderilen Mesajlar</h1>
        <div class="flex items-center gap-1 relative" x-data="{ open: false }">
            <button x-ref="sortByToggle" @click="open = !open"
                class="rounded-md px-3 py-2 border-gray-200 text-gray-700 text-sm border flex items-center gap-0.5">
                <x-icons.filter size="14" color="#131313" />
                <span class="mx-1">Sıralama Ölçütü</span>
                <template x-if="open">
                    <x-icons.chevron-up size="12" color="black" />
                </template>
                <template x-if="!open">
                    <x-icons.chevron-down size="12" color="black" />
                </template>
            </button>
            <div x-cloak x-show="open" @click.away="open = false" x-transition.origin.top.right.duration.200ms
                x-anchor.bottom-start="$refs.sortByToggle"
                class="z-10 mt-1 gap-0.5 w-full min-w-max whitespace-nowrap shadow-sm rounded-lg border border-gray-200 bg-white">
                <div class="flex flex-col gap-1 p-1.5">
                    <button wire:click="sortBy('desc')" @click="open = false"
                        class="flex @if ($orderType === 'desc') bg-gray-100 @endif text-gray-600 items-center gap-2 rounded-md px-4 py-2 text-sm font-normal capitalize hover:bg-gray-50 hover:no-underline">
                        Yeniden Eskiye
                    </button>
                    <button wire:click="sortBy('asc')" @click="open = false"
                        class="flex @if ($orderType === 'asc') bg-gray-100 @endif text-gray-600 items-center gap-2 rounded-md px-4 py-2 text-sm font-normal capitalize hover:bg-gray-50 hover:no-underline">
                        Eskiden Yeniye
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-2 p-4">
        @forelse ($messages as $message)
            <div class="flex justify-between md:items-center rounded-md border border-gray-200 bg-gray-50 p-4 gap-10">
                <div class="flex flex-row-reverse items-center justify-between w-full gap-1">
                    <x-link href="{{ route('admin.contact.show', $message) }}"
                        class="text-base hover:opacity-85 hover:no-underline bg-blue-50 border border-blue-300 text-blue-500 rounded self-start px-4 py-2">
                        Detaylar
                    </x-link>
                    <div class="flex flex-col gap-1">
                        <p class="text-sm text-gray-600">{{ $message->name }}
                            tarafından
                            {{ $message->created_at->locale('tr')->diffForHumans() }} gönderildi.</p>
                        <span class="text-sm text-gray-500">{{ $message->email }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-4 mt-3">
                <p class="text-sm text-gray-600">Şu ana kadar kimse mesaj yazmamış.</p>
            </div>
        @endforelse
    </div>
    {{ $messages->links('livewire.pagination.simple') }}
</div>
