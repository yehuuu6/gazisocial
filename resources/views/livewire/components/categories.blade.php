<div x-cloak x-show="open" @click.away="open = false" x-transition.duration.250ms
    class="absolute flex flex-col gap-0.5 mt-1 shadow-md border border-gray-200 w-[225px] md:w-[250px] z-10 lg:w-[275px] bg-white rounded-lg overflow-hidden">
    <input wire:model.live="query" type="text" spellcheck="false"
        class="mx-2 mt-2 mb-0.5 px-2 py-1 text-sm text-gray-700 border shadow rounded-md border-gray-300 focus:outline-none focus:border-blue-400"
        placeholder="Kategori Ara" />

    <div class="max-h-[200px] md:max-h-[225px] lg:max-h-[250px] overflow-y-auto">
        @forelse ($tags as $tag)
            <div wire:key="tag-{{ $tag->id }}" class="m-2">
                <x-link
                    class="flex capitalize items-center text-sm hover:no-underline gap-2 hover:bg-[#E5E7EB]/50 px-2 py-1 rounded-md font-normal"
                    href="/categories/{{ Str::slug($tag->name) }}">
                    <x-icons.folder size="20" color="gray" />{{ $tag->name }}
                </x-link>
            </div>
        @empty
            <div class="m-2">
                <span
                    class="flex capitalize items-center text-sm hover:no-underline gap-2 hover:bg-[#E5E7EB]/50 px-2 py-1 rounded-md font-normal">
                    <x-icons.folder size="20" color="gray" />Kategori Bulunamadı
                </span>
            </div>
        @endforelse
    </div>
</div>
