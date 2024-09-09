<div class="flex flex-col h-full">
    <div class="flex-grow h-full" wire:loading>
        <div class="flex items-start h-full w-full justify-center">
            <x-icons.spinner size="64" class="mt-14" />
        </div>
    </div>
    <x-scrollable-wrapper class="flex-grow">
        <ul wire:loading.remove class="divide-y flex flex-1 flex-col gap-1">
            @forelse ($posts as $post)
                <livewire:components.user.user-post :$post wire:key="post-{{ $post->id }}" />
            @empty
                <h3 class="text-center text-lg text-gray-600 mt-5">Burada gösterilecek bir şey yok.</h3>
            @endforelse
        </ul>
    </x-scrollable-wrapper>
    {{ $posts->links('livewire.pagination.simple') }}
</div>
