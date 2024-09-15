<x-scrollable-wrapper class="h-1/2 hidden sm:inline-block">
    @foreach ($tags as $tag)
        <div wire:key="tag-{{ $tag->id }}" class="m-2">
            <x-link
                class="flex capitalize items-center text-lg hover:no-underline gap-2 hover:bg-[#E5E7EB]/50 px-2 py-1 rounded-md font-normal"
                href="/categories/{{ Str::slug($tag->name) }}">
                <x-icons.folder size="20" />{{ $tag->name }}
            </x-link>
        </div>
    @endforeach
</x-scrollable-wrapper>
