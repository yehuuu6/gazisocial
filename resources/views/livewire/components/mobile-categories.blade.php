<div id="responsive-categories"
    class="absolute top-[3.5rem] w-2/3 h-2/3 -right-2/3 transition-all duration-100 p-2 rounded-b-lg bg-primary z-10 flex flex-col gap-2 md:hidden">
    <x-scrollable-wrapper class="h-full" scrollTheme="dark">
        @foreach ($tags as $tag)
            <div wire:key="tag-{{ $tag->id }}">
                <x-link
                    class="flex capitalize items-center text-lg hover:no-underline my-1 gap-2 hover:bg-blue-200 hover:bg-opacity-30 px-2 py-1 rounded-md font-normal"
                    href="/categories/{{ Str::slug($tag->name) }}">
                    <x-icons.folder size="20" color="white" />{{ $tag->name }}
                </x-link>
            </div>
        @endforeach
    </x-scrollable-wrapper>
</div>
