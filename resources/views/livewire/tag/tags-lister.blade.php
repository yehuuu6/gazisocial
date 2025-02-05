<div x-data="tagsLister({{ $this->tags }}, {{ $this->tags->count() }})">
    <div x-ref="tagsAnchor">
        <x-ui.tooltip text="Konu Etiketlerini Aç" delay="1000" position='right'>
            <button x-on:click="tagsDropdown = !tagsDropdown" id="tags-button"
                class="flex items-center gap-1 md:gap-2 rounded-md bg-white px-4 py-2 text-sm font-medium capitalize shadow">
                <span x-text="displayText"></span>
                <x-icons.arrow-down size="20" x-show="!tagsDropdown" />
                <x-icons.arrow-up size="20" x-cloak x-show="tagsDropdown" />
            </button>
        </x-ui.tooltip>
    </div>
    <div x-cloak x-show="tagsDropdown" x-anchor.offset.5.bottom-start="$refs.tagsAnchor" x-transition.origin.top.left
        x-on:click.away="tagsDropdown = false" x-ref="tagsLister"
        class="bg-white border border-gray-200 rounded-md z-[2] shadow w-[240px] overflow-hidden">
        <div>
            <input type="text" placeholder="🔎    Etiket Ara" spellcheck="false"
                class="w-full px-5 py-4 text-sm outline-none placeholder:font-normal font-medium text-gray-700 border-b border-gray-200"
                x-model="search" x-on:input="searchTags()" x-ref="searchInput">
        </div>
        <div class="overflow-y-auto max-h-[250px]">
            @foreach ($this->tags as $tag)
                <button type="button" data-search-key="{{ Str::replace('-', ' ', $tag->slug) }}"
                    wire:key="tag-{{ $tag->id }}" x-on:click="updateSelectedTag('{{ $tag->slug }}')"
                    class="flex items-center gap-4 w-full px-5 py-4 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:no-underline">
                    <x-icons.tag size="20" />
                    <span>{{ $tag->name }}</span>
                </button>
            @endforeach
        </div>
        <div x-cloak x-show="foundTagCount == 0"
            class="flex items-center gap-4 px-5 py-4 text-sm font-medium text-gray-500 cursor-default select-none">
            <x-icons.sorry size="20" />
            <span>
                Etiket bulunamadı.
            </span>
        </div>
    </div>
</div>
