<div class="flex flex-col h-full">
    <div class="flex-grow h-full" wire:loading>
        <div class="flex items-start h-full w-full justify-center">
            <x-icons.spinner size="72" class="mt-14" />
        </div>
    </div>
    <x-scrollable-wrapper class="flex-grow">
        <div wire:loading.remove class="divide-y">
            @forelse ($comments as $comment)
                <livewire:components.user.user-comment :$comment :key="$comment->id" />
            @empty
                <li>
                    <p class="text-gray-500">Henüz hiç yorum yapmamış.</p>
                </li>
            @endforelse
        </div>
    </x-scrollable-wrapper>
    <div>
        {{ $comments->links('livewire.pagination.simple') }}
    </div>
</div>
