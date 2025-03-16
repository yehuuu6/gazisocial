<div class="rounded-xl border border-gray-100 bg-white shadow-md" x-init="$wire.on('scroll-to-results', () => {
    $refs.searchResults.scrollIntoView({ behavior: 'smooth', block: 'start' });
})">
    <div class="p-4 md:p-8">
        <h1 class="text-xl md:text-3xl font-bold text-gray-900 mb-6">
            Gelişmiş Arama
        </h1>
        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-3">
            Arama Kriterleri
        </h2>
        <div class="mb-3">
            <label for="search" class="text-sm md:text-base font-normal text-gray-600">
                Ara
            </label>
            <input type="text" wire:model="search" id="search" spellcheck="false" autocomplete="off"
                placeholder="Aranacak kelimeleri girin..."
                class="rounded-md text-gray-600 w-full mt-2 text-sm md:text-base outline-none border border-gray-200 p-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="mb-3" x-data="{
            selectedTags: $wire.entangle('selectedTags'),
            insertTag(tagId) {
                // If its not already in the array, add it. If it is in the array, remove it.
                this.selectedTags.includes(tagId) ? this.selectedTags = this.selectedTags.filter(item => item !== tagId) : this.selectedTags = [...this.selectedTags, tagId];
            }
        }">
            <h3 class="text-sm md:text-base font-normal text-gray-600">
                Etiketler
            </h3>
            <div class="mt-2 grid grid-cols-3 xl:grid-cols-5 gap-3.5 md:gap-2.5">
                @foreach ($this->tags as $tag)
                    <div class="flex items-center gap-2" wire:key='tag-{{ $tag->id }}'>
                        <input type="checkbox" id="tag-selector-{{ $tag->id }}"
                            x-on:change="insertTag('{{ $tag->id }}')"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="tag-selector-{{ $tag->id }}"
                            class="ms-0.5 md:ms-2 text-xs md:text-sm text-gray-700">
                            {{ $tag->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-6">
            <button type="button" wire:click="searchPosts" wire:loading.attr="disabled"
                class="bg-primary text-white text-sm md:text-base rounded-md px-4 py-2 font-semibold hover:bg-blue-900 w-full">
                <span wire:loading.remove wire:target='searchPosts'>Ara</span>
                <span wire:loading.flex wire:target='searchPosts' class="flex items-center justify-center">
                    <x-icons.spinner size="20" />
                    <span class="ms-2">Aranıyor...</span>
                </span>
            </button>
        </div>
        <div class="mt-6">
            <div class="w-full flex items-center justify-between gap-2">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                    Arama Sonuçları
                </h2>
                <button type="button" wire:click="clearSearch" wire:loading.attr="disabled"
                    class="text-sm md:text-base text-red-500 font-semibold hover:text-red-700 flex items-center gap-1">
                    <x-icons.trash size="18" />
                    Temizle
                </button>
            </div>
            <span class="text-xs md:text-sm text-gray-500 font-normal">
                Sadece bulunan ilk 10 sonuç gösterilmektedir. Spesifik aramalar için daha fazla kelime girin.
            </span>
            <div class="mt-3 space-y-4" x-ref="searchResults">
                @forelse ($this->posts as $post)
                    <div class="bg-white rounded-md border border-gray-200 p-4 flex items-center gap-4"
                        wire:key='post-{{ $post->id }}'>
                        <div>
                            <div class="flex flex-col gap-0">
                                <x-link href="{{ $post->showRoute() }}"
                                    class="self-start text-base md:text-lg font-semibold text-blue-950 break-words">
                                    {{ $post->title }}
                                </x-link>
                                <div class="flex items-center gap-1">
                                    <span class="text-xs text-gray-500 font-light">
                                        {{ $post->created_at->locale('tr')->diffForHumans() }},
                                    </span>
                                    @if ($post->isAnonim())
                                        <span class="text-xs text-gray-600 font-semibold">
                                            Anonim
                                        </span>
                                    @else
                                        <x-link href="{{ route('users.show', $post->user->username) }}"
                                            class="text-xs text-blue-400 font-normal">
                                            {{ $post->user->name }} tarafından
                                        </x-link>
                                    @endif
                                </div>
                            </div>
                            <p class="text-xs md:text-sm text-gray-700 mt-3">
                                {{ mb_substr(strip_tags($post->html), 0, 150, 'UTF-8') }}...
                            </p>
                            <div class="flex items-center gap-2 mt-3">
                                @foreach ($post['tags'] as $tag)
                                    <x-post.post-tag :tag="$tag" />
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-sm md:text-base text-orange-400 font-light">
                        @if (strlen($this->search) > 2 && $this->posts->isEmpty())
                            <p>
                                Arama kriterlerinize uygun bir sonuç bulunamadı.
                            </p>
                        @else
                            <p>
                                Arama yapmak için en az 3 karakter girmelisiniz.
                            </p>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
