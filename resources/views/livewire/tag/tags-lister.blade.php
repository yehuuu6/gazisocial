<div x-data="{
    tagsDropdown: false,
    search: '',
    foundTagCount: {{ $this->tags->count() }},
    searchTags() {
        const tags = this.$refs.tagsLister.querySelectorAll('a');
        let count = 0;
        tags.forEach(tag => {
            let condition1 = tag.dataset.slug.toLowerCase().includes(this.search.toLowerCase());
            let condition2 = tag.innerText.toLowerCase().includes(this.search.toLowerCase());
            if (condition1 || condition2) {
                count++;
                tag.classList.remove('hidden');
            } else {
                tag.classList.add('hidden');
            }
        });
        this.foundTagCount = count;
    }
}">
    <div x-ref="tagsAnchor">
        <x-ui.tooltip text="Konu Etiketlerini Aç" delay="1000" position='bottom'>
            <button x-on:click="tagsDropdown = !tagsDropdown"
                class="flex items-center gap-2 rounded-md bg-white {{ $this->displayColor }} px-3 py-2 text-sm font-medium capitalize shadow">
                <span>{{ $displayName }}</span>
                <x-icons.arrow-down size="20" x-show="!tagsDropdown" />
                <x-icons.arrow-up size="20" x-cloak x-show="tagsDropdown" />
            </button>
        </x-ui.tooltip>
    </div>
    <div x-cloak x-show="tagsDropdown" x-anchor.offset.5.bottom-start="$refs.tagsAnchor" x-transition.origin.top.left
        x-on:click.away="tagsDropdown = false" x-ref="tagsLister"
        class="bg-white border border-gray-200 rounded-md z-[1] shadow w-[200px] md:w-[240px] overflow-hidden">
        <div>
            <input type="text" placeholder="🔎    Etiket Ara" spellcheck="false"
                class="w-full px-4 py-2.5 md:px-5 md:py-4 text-sm outline-none placeholder:font-normal font-medium text-gray-700 border-b border-gray-200"
                x-model="search" x-on:input="searchTags()" x-ref="searchInput">
        </div>
        <div class="max-h-[200px] overflow-y-auto md:max-h-[225px] lg:max-h-[250px]">
            @foreach ($this->tags as $tag)
                <a wire:navigate href="{{ route('tags.show', $tag->slug) }}" data-slug="{{ $tag->slug }}"
                    class="flex items-center gap-4 px-4 py-2.5 md:px-5 md:py-4 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:no-underline">
                    <x-icons.tag size="20" />
                    <span>{{ $tag->name }}</span>
                </a>
            @endforeach
        </div>
        <div x-cloak x-show="foundTagCount == 0"
            class="flex items-center gap-4 px-4 py-2.5 md:px-5 md:py-4 text-sm font-medium text-gray-500 cursor-default select-none">
            <x-icons.sorry size="20" />
            <span>
                Etiket bulunamadı.
            </span>
        </div>
    </div>
</div>
