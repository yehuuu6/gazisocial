<div class="flex flex-col h-full">
    <div class="flex-grow h-full" wire:loading>
        <div class="flex items-start h-full w-full justify-center">
            <x-icons.spinner size="72" class="mt-14" />
        </div>
    </div>
    <x-scrollable-wrapper class="flex-grow">
        <div wire:loading.remove>
            @forelse ($posts as $post)
                <li :key="{{ $post->id }}">
                    {{ $post->title }}
                </li>
            @empty
                <li>
                    <p class="text-gray-500">Henüz hiç konu açmamış.</p>
                </li>
            @endforelse
        </div>
    </x-scrollable-wrapper>
    <div>
        {{ $posts->links('livewire.pagination.simple') }}
    </div>
</div>
