<div class="flex flex-col h-full">
    <div class="flex-grow h-full" wire:loading>
        <div class="flex items-start h-full w-full justify-center">
            <x-icons.spinner size="64" class="my-14" />
        </div>
    </div>
    <div wire:loading.flex.remove class="p-5 flex flex-col gap-5 items-center justify-center">
        @forelse ($likes as $like)
            <livewire:components.user.user-comment :$like wire:key="like-{{ $like->id }}" />
        @empty
            <h3 class="text-center text-lg my-14 text-gray-600">Burada gösterilecek bir şey yok.</h3>
        @endforelse
    </div>
</div>
