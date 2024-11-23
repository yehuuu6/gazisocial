@push('scripts')
    @vite('resources/js/editor.js')
@endpush
<div x-data="{
    deletePollModal: false,
    pollId: null
}" class="flex flex-col rounded-xl border overflow-hidden border-gray-100 bg-white shadow-md">
    @auth
        <livewire:modals.delete-poll-modal />
    @endauth
    <form wire:submit="savePost" class="flex h-full flex-col">
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
                    <x-editor wire:model="content" :$content spellcheck="false" />
                </div>
                <div class="flex flex-col gap-2 px-4">
                    <h4 class="flex items-center gap-1 cursor-default font-medium text-gray-700">
                        Gizlilik
                    </h4>
                    <div
                        class="self-start py-2 px-4 flex gap-2.5 items-center rounded-md border border-orange-200 bg-orange-50 text-orange-400 text-sm font-normal">
                        <x-icons.info color="orange" size="18" />
                        <span>
                            Konu oluşturduktan sonra gizlilik ayarını değiştiremezsiniz.
                        </span>
                    </div>
                </div>
                <div x-data="{ selectedTags: $wire.entangle('selectedTags') }" class="flex flex-col gap-2 px-4">
                    <h4 class="block cursor-default font-medium text-gray-700">Etiketler</h4>
                    <input type="hidden" name="tags" id="tags" wire:model='selectedTags'>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($tags as $tag)
                            <button
                                x-on:click="selectedTags.includes({{ $tag->id }}) ? selectedTags.splice(selectedTags.indexOf({{ $tag->id }}), 1) : selectedTags.push({{ $tag->id }})"
                                type="button"
                                x-bind:class="selectedTags.includes({{ $tag->id }}) ? 'bg-{{ $tag->color }}-500 text-white' :
                                    'bg-gray-100 hover:bg-gray-200 text-gray-700'"
                                class="flex items-center gap-1 rounded-full px-3 py-1 shadow-sm focus:outline-none sm:text-sm">
                                <template x-if="selectedTags.includes({{ $tag->id }})">
                                    <x-icons.minus color='white' size='14' />
                                </template>
                                <template x-if="!selectedTags.includes({{ $tag->id }})">
                                    <x-icons.plus color='#6366f1' size='14' />
                                </template>
                                {{ $tag->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col gap-2 px-4" x-data="{ polls: $wire.entangle('createdPolls') }">
                    <h3 class="block cursor-default font-medium text-gray-700">Anketler</h3>
                    <div class="flex gap-5">
                        <template x-for="(poll, pollIndex) in polls" :key="pollIndex">
                            <div class="flex flex-grow flex-col gap-1 rounded-md border border-gray-300 p-4 shadow-sm">
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-xl font-medium text-gray-700" x-text="poll.question"></h3>
                                            <template x-if="poll.is_active">
                                                <x-tooltip position="right" text="Kullanıcılar ankete oy vermiş!">
                                                    <x-icons.info color='orange' size='20' />
                                                </x-tooltip>
                                            </template>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <button type="button"
                                                x-on:click="
                                                    console.log('Poll ID:', poll.id);
                                                    pollId = poll.id;
                                                    deletePollModal = true;
                                                    $dispatch('delete-poll-modal-open');
                                                "
                                                class="hover:opacity-80">
                                                <x-tooltip text="Sil">
                                                    <x-icons.trash size='18' color="#ff6969" />
                                                </x-tooltip>
                                            </button>
                                        </div>
                                    </div>
                                    <template x-for="(option, optionIndex) in poll.options" :key="optionIndex">
                                        <div
                                            class="rounded-md border-2 border-gray-200 px-3 py-2 transition-all duration-500">
                                            <div class="flex flex-grow flex-col px-1 pb-1 gap-2">
                                                <div class="flex w-full items-center">
                                                    <label :for="'option-input-' + optionIndex"
                                                        class="flex flex-1 items-center justify-between">
                                                        <div>
                                                            <span class="text-gray-700" x-text="option.option"></span>
                                                            <span class="text-sm text-gray-500"
                                                                x-text="'(' + option.votes_count + ' oy)'"></span>
                                                        </div>
                                                        <span class="text-gray-500 text-sm"
                                                            x-text="option.percentage + '%'"></span>
                                                    </label>
                                                </div>
                                                <div class="w-full rounded-full bg-gray-300">
                                                    <div class="h-2 rounded-full bg-blue-500 transition-all duration-1000"
                                                        :style="'width: ' + option.percentage + '%'">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div
                        class="self-start py-2 px-4 flex gap-2.5 items-center rounded-md border border-orange-200 bg-orange-50 text-orange-400 text-sm font-normal">
                        <x-icons.info color="orange" size="18" />
                        <span>
                            Konu oluşturulduktan sonra yeni anket oluşturamaz veya mevcut anketleri düzenleyemezsiniz.
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <x-seperator />
        <div class="flex items-center justify-between bg-gray-50 p-6">
            <x-link href="{{ $post->showRoute() }}"
                class="rounded px-4 py-2 font-medium text-red-500 outline-none hover:bg-red-100 hover:no-underline">
                İptal
            </x-link>
            <div class="flex justify-end gap-4">
                <button type="submit" wire:loading.class='animate-pulse' wire:loading.attr='disabled'
                    wire:target='savePost'
                    class="rounded bg-blue-500 px-6 py-2 font-medium text-white outline-none hover:bg-blue-600">
                    Kaydet
                </button>
            </div>
        </div>
    </form>
</div>
