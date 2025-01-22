<div class="flex flex-col overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
    <form wire:submit="createPost" class="flex h-full flex-col">
        <div class="flex-grow">
            <div class="flex flex-col gap-5 py-4">
                <div class="flex flex-col gap-2 px-4">
                    <label for="title" class="block font-medium text-gray-700">Başlık</label>
                    <input wire:model="title" type="text" id="title" name="title" maxlength="100" minlength="6"
                        required
                        class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500" />
                </div>
                <div class="flex flex-col gap-2 px-4">
                    <h4 class="block font-medium text-gray-700">İçerik</h4>
                    <x-editor wire:model="content"></x-editor>
                </div>
                <div x-data="{ selectedTags: $wire.selectedTags }" class="flex flex-col gap-2 px-4">
                    <h4 class="block cursor-default font-medium text-gray-700">Etiketler</h4>
                    <input type="hidden" name="tags" id="tags" wire:model='selectedTags'>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($this->tags as $tag)
                            <button
                                x-on:click="selectedTags.includes({{ $tag->id }}) ? selectedTags.splice(selectedTags.indexOf({{ $tag->id }}), 1) : selectedTags.push({{ $tag->id }})"
                                type="button"
                                x-bind:class="selectedTags.includes({{ $tag->id }}) ? 'bg-{{ $tag->color }}-500 text-white' :
                                    'bg-gray-100 hover:bg-gray-200 text-gray-700'"
                                class="flex items-center gap-1 rounded-full px-3 py-1 shadow-sm focus:outline-none sm:text-sm">
                                <template x-if="selectedTags.includes({{ $tag->id }})">
                                    <x-icons.hide size='14' />
                                </template>
                                <template x-if="!selectedTags.includes({{ $tag->id }})">
                                    <x-icons.show size='14' />
                                </template>
                                {{ $tag->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col gap-2 px-4">
                    <h3 class="block cursor-default font-medium text-gray-700">Anketler</h3>
                    <div class="flex gap-5">
                    </div>
                    <h3 class="text-sm text-gray-500">Hiç anket eklenmemiş.</h3>
                </div>
                <div class="px-4 self-start">
                    <div
                        class="py-2 px-4 flex gap-2.5 items-center rounded-md border border-orange-200 bg-orange-50 text-orange-400 text-sm font-normal">
                        <x-icons.info color="orange" size="18" />
                        <span>
                            Konu oluşturduktan sonra yeni anket oluşturamaz ve mevcut anketleri düzenleyemezsiniz.
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <x-seperator />
        <div class="flex justify-end gap-4 bg-gray-50 p-6">
            <button type="button"
                class="outline:none rounded border border-green-500 bg-transparent px-6 py-2 font-medium text-green-500 outline-none hover:bg-green-500 hover:text-white">
                Anket Oluştur
            </button>
            <button type="submit" wire:loading.class='animate-pulse' wire:loading.attr='disabled'
                wire:target='createPost'
                class="rounded bg-blue-500 px-6 py-2 font-medium text-white outline-none hover:bg-blue-600">
                Yayınla
            </button>
        </div>
    </form>
</div>
