<div x-init="$wire.on('scroll-to-results', () => {
    $refs.searchResults.scrollIntoView({ behavior: 'smooth', block: 'start' });
})">
    <div class="rounded-xl border border-gray-100 bg-white shadow-md p-8">
        <h1 class="text-3xl font-bold text-primary mb-6">Gelişmiş Arama</h1>

        <div class="mb-10">
            <h2 class="text-base md:text-lg font-medium text-gray-800 mb-4">
                Arama Kriterleri
            </h2>

            <div class="mb-5">
                <label for="search" class="text-sm font-normal text-gray-600 block mb-2">
                    Ara
                </label>
                <input type="text" wire:model="search" id="search" spellcheck="false" autocomplete="off"
                    placeholder="Aranacak kelimeleri girin..."
                    class="rounded-md w-full py-2 px-3 text-sm text-gray-700 border border-gray-200 focus:ring-1 focus:ring-primary focus:border-primary transition">
            </div>

            <div class="mb-6" x-data="{
                selectedTags: $wire.entangle('selectedTags'),
                insertTag(tagId) {
                    this.selectedTags.includes(tagId) ? this.selectedTags = this.selectedTags.filter(item => item !== tagId) : this.selectedTags = [...this.selectedTags, tagId];
                }
            }">
                <div class="text-sm font-normal text-gray-600 mb-2">
                    Etiketler
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach ($this->tags as $tag)
                        <button type="button" wire:key='tag-{{ $tag->id }}'
                            x-on:click="insertTag('{{ $tag->id }}')"
                            :class="{
                                'bg-blue-50 border-primary text-primary': selectedTags.includes(
                                    '{{ $tag->id }}'),
                                'bg-white hover:bg-gray-50': !selectedTags.includes(
                                    '{{ $tag->id }}')
                            }"
                            class="text-xs text-gray-600 border border-gray-200 rounded px-3 py-1.5 transition">
                            {{ $tag->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div>
                <button type="button" wire:click="searchPosts" wire:loading.attr="disabled"
                    class="bg-primary text-white text-sm rounded px-4 py-2 hover:bg-blue-700 transition inline-flex items-center">
                    <span wire:loading.remove wire:target='searchPosts'>Ara</span>
                    <span wire:loading.flex wire:target='searchPosts' class="flex items-center">
                        <x-icons.spinner size="16" />
                        <span class="ms-2">Aranıyor...</span>
                    </span>
                </button>
            </div>
        </div>

        <div>
            <div class="w-full flex items-center justify-between gap-2 mb-3">
                <h2 class="text-base md:text-lg font-medium text-gray-800">
                    Arama Sonuçları
                </h2>
                <button type="button" wire:click="clearSearch" wire:loading.attr="disabled"
                    class="text-xs text-red-500 hover:text-red-700 transition">
                    Temizle
                </button>
            </div>
            <p class="text-xs text-gray-500 mb-4">
                Sadece bulunan ilk 10 sonuç gösterilmektedir. Spesifik aramalar için daha fazla kelime girin.
            </p>
            <div class="space-y-5" x-ref="searchResults">
                @forelse ($this->posts as $post)
                    <div class="border-b border-gray-100 pb-5" wire:key='post-{{ $post->id }}'>
                        <div class="flex flex-col">
                            <x-link href="{{ $post->showRoute() }}"
                                class="text-base font-medium text-gray-900 hover:text-primary transition">
                                {{ $post->title }}
                            </x-link>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $post->created_at->locale('tr')->diffForHumans() }},
                                @if ($post->isAnonim())
                                    <span class="text-gray-600">Anonim</span>
                                @else
                                    <x-link href="{{ route('users.show', $post->user->username) }}"
                                        class="text-gray-600 hover:text-primary transition">
                                        {{ $post->user->name }} tarafından
                                    </x-link>
                                @endif
                            </div>
                            <p class="text-xs text-gray-600 mt-2">
                                {{ mb_substr(strip_tags($post->html), 0, 150, 'UTF-8') }}...
                            </p>
                            <div class="flex flex-wrap gap-1.5 mt-3">
                                @foreach ($post['tags'] as $tag)
                                    <x-post.post-tag :tag="$tag" />
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-600 py-3">
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
