<div x-cloak x-show="open" @click.away="open = false" x-collapse x-anchor.bottom-start="$refs.tagsToggle"
    class="flex flex-col z-10 gap-0.5 mt-1 shadow-md border border-gray-200 w-[225px] md:w-[250px] lg:w-[275px] bg-white rounded-lg overflow-hidden">
    <input wire:model.live="query" type="text" spellcheck="false"
        class="mx-2 mt-2 mb-0.5 px-2 py-1 text-sm text-gray-700 border shadow rounded-md border-gray-300 focus:outline-none focus:border-blue-400"
        placeholder="Etiket Ara" />

    <div class="max-h-[200px] md:max-h-[225px] lg:max-h-[250px] overflow-y-auto">
        @forelse ($tags as $tag)
            <div wire:key="tag-{{ $tag->id }}" class="m-2">
                <x-link
                    class="flex capitalize items-center text-sm hover:no-underline gap-2 hover:bg-[#E5E7EB]/50 px-2 py-1 rounded-md font-normal"
                    href="{{ route('tags.show', $tag->slug) }}">
                    <x-icons.folder size="20" color="gray" />{{ $tag->name }}
                </x-link>
            </div>
        @empty
            <div class="m-2">
                <span
                    class="flex capitalize items-center text-sm hover:no-underline gap-2 hover:bg-[#E5E7EB]/50 px-2 py-1 rounded-md font-normal">
                    <x-icons.folder size="20" color="gray" />Etiket Bulunamadı
                </span>
            </div>
        @endforelse
    </div>
</div>
