<div class="flex flex-col h-full">
    <div class="flex-grow h-full" wire:loading>
        <div class="flex items-start h-full w-full justify-center">
            <x-icons.spinner size="64" class="mt-14" />
        </div>
    </div>
    <x-scrollable-wrapper class="flex-grow">
        <div wire:loading.remove class="p-5 flex flex-col gap-5 items-center justify-center">
            @forelse ($comments as $comment)
                <livewire:components.user.user-comment :$comment wire:key="comment-{{ $comment->id }}" />
            @empty
                <h3 class="text-center text-lg text-gray-600">Burada gösterilecek bir şey yok.</h3>
            @endforelse
        </div>
    </x-scrollable-wrapper>
    <div>
        {{ $comments->links('livewire.pagination.simple') }}
    </div>
</div>
