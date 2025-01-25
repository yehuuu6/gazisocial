<div x-data="tagsLister({{ $this->tags }}, {{ $this->tags->count() }})">
    <div x-ref="tagsAnchor">
        <x-ui.tooltip text="Konu Etiketlerini Aç" delay="1000" position='bottom'>
            <button x-on:click="tagsDropdown = !tagsDropdown" id="tags-button"
                class="flex items-center gap-1 md:gap-2 rounded-md bg-white md:px-4 py-2 text-xs px-3 md:text-sm font-medium capitalize shadow">
                <span x-text="displayText"></span>
                <x-icons.arrow-down size="18" x-show="!tagsDropdown" />
                <x-icons.arrow-up size="18" x-cloak x-show="tagsDropdown" />
            </button>
        </x-ui.tooltip>
    </div>
    <div x-cloak x-show="tagsDropdown" x-anchor.offset.5.bottom-start="$refs.tagsAnchor" x-transition.origin.top.left
        x-on:click.away="tagsDropdown = false" x-ref="tagsLister"
        class="bg-white border border-gray-200 rounded-md z-[1] shadow w-[175px] md:w-[240px] overflow-hidden">
        <div>
            <input type="text" placeholder="🔎    Etiket Ara" spellcheck="false"
                class="w-full px-4 py-2.5 md:px-5 md:py-4 text-xs md:text-sm outline-none placeholder:font-normal font-medium text-gray-700 border-b border-gray-200"
                x-model="search" x-on:input="searchTags()" x-ref="searchInput">
        </div>
        <div class="max-h-[200px] overflow-y-auto md:max-h-[225px] lg:max-h-[250px]">
            @foreach ($this->tags as $tag)
                <button type="button" data-search-key="{{ Str::replace('-', ' ', $tag->slug) }}"
                    wire:key="tag-{{ $tag->id }}" x-on:click="updateSelectedTag('{{ $tag->slug }}')"
                    class="flex items-center gap-4 w-full px-4 py-2.5 md:px-5 md:py-4 text-xs md:text-sm font-medium text-gray-700 hover:bg-gray-100 hover:no-underline">
                    <x-icons.tag size="18" />
                    <span>{{ $tag->name }}</span>
                </button>
            @endforeach
        </div>
        <div x-cloak x-show="foundTagCount == 0"
            class="flex items-center gap-4 px-4 py-2.5 md:px-5 md:py-4 text-xs md:text-sm font-medium text-gray-500 cursor-default select-none">
            <x-icons.sorry size="18" />
            <span>
                Etiket bulunamadı.
            </span>
        </div>
    </div>
</div>
