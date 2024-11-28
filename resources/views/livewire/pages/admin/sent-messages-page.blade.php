<div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
    <h1 class="text-3xl font-bold text-gray-900 mx-6 mt-6">Gönderilen Mesajlar</h1>
    <div class="flex flex-col gap-2 p-4">
        @forelse ($messages as $message)
            <div class="flex justify-between md:items-center rounded-md border border-gray-200 bg-gray-50 p-4 gap-10">
                <div class="flex flex-col gap-1">
                    <x-link href="{{ route('admin.contact.show', $message) }}"
                        class="text-lg font-medium">{{ $message->email }}</x-link>
                    <p class="text-sm text-gray-600">{{ $message->name }}
                        tarafından
                        {{ $message->created_at->locale('tr')->diffForHumans() }} bildirildi.</p>
                </div>
            </div>
        @empty
            <div class="rounded-md shadow p-4">
                <p class="text-sm text-gray-600">Şu ana kadar kimse mesaj yazmamış.</p>
            </div>
        @endforelse
    </div>
    {{ $messages->links('livewire.pagination.simple') }}
</div>
