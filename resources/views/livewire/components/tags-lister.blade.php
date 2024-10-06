<div x-cloak x-show="open" @click.away="open = false" x-collapse x-anchor.bottom-start="$refs.tagsToggle"
    class="z-10 mt-1 flex w-[225px] flex-col gap-0.5 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-md md:w-[250px] lg:w-[275px]">
    <input wire:model.live="query" type="text" spellcheck="false" id="tags-search" name="tags-search"
        class="mx-2 mb-0.5 mt-2 rounded-md border border-gray-300 px-2 py-1 text-sm text-gray-700 shadow focus:border-blue-400 focus:outline-none"
        placeholder="Etiket Ara" />

    <div class="max-h-[200px] overflow-y-auto md:max-h-[225px] lg:max-h-[250px]">
        @forelse ($tags as $tag)
            <div wire:key="tag-{{ $tag->id }}" class="m-2">
                <x-link
                    class="flex items-center gap-2 rounded-md px-2 py-1 text-sm font-normal capitalize hover:bg-[#E5E7EB]/50 hover:no-underline"
                    href="{{ route('tags.show', $tag->slug) }}">
                    <x-icons.folder size="20" color="gray" />{{ $tag->name }}
                </x-link>
            </div>
        @empty
            <div class="m-2">
                <span
                    class="flex items-center gap-2 rounded-md px-2 py-1 text-sm font-normal capitalize hover:bg-[#E5E7EB]/50 hover:no-underline">
                    <x-icons.folder size="20" color="gray" />Etiket Bulunamadı
                </span>
            </div>
        @endforelse
    </div>
</div>
