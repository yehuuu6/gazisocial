@push('scripts')
    @vite('resources/js/editor.js')
@endpush
<div x-data="{ createPollModal: false, switchOn: $wire.entangle('isAnon') }" class="flex flex-col rounded-xl border overflow-hidden border-gray-100 bg-white shadow-md">
    <livewire:modals.create-poll-modal />
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
                        <span>Gizlilik</span>
                        <x-tooltip x-show="switchOn" position="right"
                            text="Yöneticiler kimliğinizi her zaman görebilir.">
                            <x-icons.info size='17' color='orange' />
                        </x-tooltip>
                    </h4>
                    <div class="flex items-center gap-2">
                        <input id="isAnon" type="checkbox" name="isAnon" class="hidden" :checked="switchOn">
                        <button x-ref="switchButton" type="button" @click="switchOn = ! switchOn"
                            :class="switchOn ? 'bg-blue-600' : 'bg-neutral-200'"
                            class="relative inline-flex h-6 py-0.5 focus:outline-none rounded-full w-10" x-cloak>
                            <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'"
                                class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
                        </button>

                        <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
                            :class="{ 'text-blue-600': switchOn, 'text-gray-500': !switchOn }"
                            class="text-sm select-none" x-cloak>
                            Anonim olarak paylaş
                        </label>
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
                                                <x-tooltip text="Kullanıcılar ankete oy vermiş!">
                                                    <x-icons.info color='orange' size='20' />
                                                </x-tooltip>
                                            </template>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <button type="button" class="hover:opacity-80">
                                                <x-tooltip text="Düzenle">
                                                    <x-icons.edit color='#4b5563' size='20' />
                                                </x-tooltip>
                                            </button>
                                            <button type="button" x-on:click="polls.splice(pollIndex, 1)"
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
                    <h3 x-show="polls.length === 0" class="text-sm text-gray-500">
                        Hiç anket eklenmemiş.
                    </h3>
                    <h3 x-show="polls.length > 0" class="text-sm text-orange-400 mt-3.5">
                        Oluşturduğunuz anketler taslaktır ve konuyu yayınlamadığınız sürece görünmeyecektir.
                    </h3>
                </div>
            </div>
        </div>
        <x-seperator />
        <div class="flex items-center justify-between bg-gray-50 p-6">
            <x-link href="{{ route('posts.index') }}"
                class="rounded px-4 py-2 font-medium text-red-500 outline-none hover:bg-red-100 hover:no-underline">
                İptal
            </x-link>
            <div class="flex justify-end gap-4">
                <button wire:click='test' type="button"
                    class="rounded bg-orange-50 px-6 py-2 font-medium text-orange-400 outline-none hover:bg-orange-100">
                    Debug
                </button>
                <button type="button" @click="createPollModal = true"
                    class="outline:none rounded border border-green-500 bg-transparent px-6 py-2 font-medium text-green-500 outline-none hover:bg-green-500 hover:text-white">
                    Anket Ekle
                </button>
                <button type="submit" wire:loading.class='animate-pulse' wire:loading.attr='disabled'
                    wire:target='savePost'
                    class="rounded bg-blue-500 px-6 py-2 font-medium text-white outline-none hover:bg-blue-600">
                    Kaydet
                </button>
            </div>
        </div>
    </form>
</div>
