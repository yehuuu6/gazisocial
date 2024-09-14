<div class="flex flex-col h-full">
    <div class="flex-grow h-full" wire:loading>
        <div class="flex items-start h-full w-full justify-center">
            <x-icons.spinner size="64" class="mt-14" />
        </div>
    </div>
    <x-scrollable-wrapper class="flex-grow">
        <ul wire:loading.remove class="p-5 flex flex-col gap-5 items-center justify-center">
            @forelse ($posts as $post)
                <livewire:components.user.user-post :$post wire:key="post-{{ $post->id }}" />
            @empty
                <h3 class="text-center text-lg text-gray-600 mt-5">Burada gösterilecek bir şey yok.</h3>
            @endforelse
        </ul>
    </x-scrollable-wrapper>
    {{ $posts->links('livewire.pagination.simple') }}
</div>
