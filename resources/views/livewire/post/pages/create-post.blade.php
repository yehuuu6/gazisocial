@push('scripts')
    @vite('resources/js/editor.js')
    @vite('resources/js/poll-creator.js')
@endpush
<div x-data="{
    optionsCount: $wire.entangle('optionsCount'),
    options: $wire.entangle('options'),
    saveOptions() {
        this.options = [];
        this.$nextTick(() => {
            const optionValues = document.querySelectorAll('[data-option]');
            optionValues.forEach((option) => {
                if (option.value.trim() !== '') {
                    this.options.push(option.value.trim());
                }
            });
            if (this.options.length >= 2) {
                $wire.call('createPoll');
            } else {
                Toaster.error('En az 2 seçenek eklemelisiniz.');
            }
        });
    },
    addOption() {
        if (this.optionsCount >= 10) Toaster.warning('En fazla 10 seçenek ekleyebilirsiniz.');
        else this.optionsCount++;
    },
    removeOption() {
        if (this.optionsCount <= 2) Toaster.warning('En az 2 seçenek olmalı.');
        else this.optionsCount--;
    },
}">
    <x-poll.promotion-banner />
    <form wire:submit="createPost" class="rounded-xl border border-gray-100 bg-white shadow-md">
        <div class="flex-grow">
            <div wire:ignore x-data="{ navbarHeight: 0 }" x-init="navbarHeight = document.getElementById('navbar').offsetHeight;
            $el.style.top = navbarHeight + 'px';"
                class="flex items-center justify-between gap-4 sticky z-[2] bg-white px-4 lg:px-6 rounded-t-xl py-2.5 lg:py-4 border-b border-gray-200">
                <h1 class="text-base md:text-xl flex items-center gap-2 font-bold text-gray-800">
                    <div class="size-4 md:size-6 rounded-sm bg-gradient-to-t from-blue-500 to-blue-300 flex-shrink-0">
                    </div>
                    Yeni Konu
                </h1>
                <button type="button" wire:click="createPost"
                    class="px-3 py-1.5 text-xs lg:text-base md:px-4 md:py-2 rounded bg-primary bg-opacity-90 hover:bg-opacity-100 text-white font-semibold">
                    Yayınla
                </button>
            </div>
            <div class="flex flex-col gap-5 md:gap-7 p-4 lg:p-6">
                <div class="flex flex-col md:flex-row gap-3 md:gap-6">
                    <div class="w-full md:w-[300px]">
                        <label for="title" class="block text-lg lg:text-xl font-medium text-gray-700">
                            Konu Başlığı
                        </label>
                        <p class="text-xs lg:text-sm text-gray-500">
                            Dikkat çekici ve anlaşılır bir başlık kullanıcıların konunuza daha fazla ilgi göstermesini
                            sağlar.
                        </p>
                    </div>
                    <textarea wire:model="title" id="title" name="title" rows="1" spellcheck="false"
                        class="flex-grow px-4 py-2 text-base lg:text-lg font-medium text-gray-800 bg-gray-50 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-80 resize-none"
                        placeholder="Konu başlığınızı buraya yazın..."></textarea>
                </div>
                <div x-data="{
                    selectedTags: $wire.selectedTags,
                }" class="flex flex-col md:flex-row gap-3 md:gap-6">
                    <div class="w-full md:w-[300px] shrink-0">
                        <h4
                            class="block cursor-default font-medium text-lg md:text-xl
                        text-gray-700">
                            Etiketler
                        </h4>
                        <p class="text-xs lg:text-sm text-gray-500">
                            Konunuzun kategorilendirilmesi için en az 2, en fazla ise 4
                            etiket olacak şekilde seçim yapabilirsiniz.
                        </p>
                    </div>
                    <div
                        class="p-4 border-2 border-transparent bg-gray-50 active:border-blue-500 active:border-opacity-80 rounded-md flex flex-wrap gap-3 items-start h-fit w-full">
                        @foreach ($this->tags as $tag)
                            <button wire:key="tag-{{ $tag->id }}"
                                x-on:click="selectedTags.includes({{ $tag->id }}) ? selectedTags.splice(selectedTags.indexOf({{ $tag->id }}), 1) : selectedTags.push({{ $tag->id }})"
                                type="button"
                                :class="selectedTags.includes({{ $tag->id }}) ?
                                    'bg-{{ $tag->color }}-500 text-white' :
                                    'bg-gray-200 text-gray-700'"
                                class="rounded-full hover:bg-opacity-80 px-2.5 py-1 shadow-sm focus:outline-none text-xs lg:text-sm active:scale-90 transition-transform duration-100">
                                {{ $tag->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-3 md:gap-6">
                    <div class="w-full md:w-[300px] shrink-0">
                        <h4 class="block cursor-default font-medium text-lg md:text-xl text-gray-700">
                            Anonim Paylaşım
                        </h4>
                        <p class="text-xs lg:text-sm text-gray-500">
                            Anonim konularda yöneticiler kimliğinizi her zaman görebilir.
                        </p>
                    </div>
                    <div
                        class="p-4 border-2 border-transparent bg-gray-50 active:border-blue-500 active:border-opacity-80 rounded-md flex items-center h-fit w-full">
                        <label for="is_anonim" class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="is_anonim" wire:model="is_anonim" class="sr-only peer">
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-700">Anonim olarak paylaş</span>
                        </label>
                    </div>
                </div>
                @can('pin', App\Models\Post::class)
                    <div class="flex flex-col md:flex-row gap-3 md:gap-6">
                        <div class="w-full md:w-[300px] shrink-0">
                            <h4 class="block cursor-default font-medium text-lg md:text-xl text-gray-700">
                                Sabitlenmiş Konu
                            </h4>
                            <p class="text-xs lg:text-sm text-gray-500">
                                Yönetici olduğunuz için konunuzu doğrudan sabitleyebilirsiniz. Daha sonra panelden bu değeri
                                değiştirebilirsiniz.
                            </p>
                        </div>
                        <div
                            class="p-4 border-2 border-transparent bg-gray-50 active:border-blue-500 active:border-opacity-80 rounded-md flex items-center h-fit w-full">
                            <label for="is_pinned" class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="is_pinned" wire:model="is_pinned" class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                                <span class="ms-3 text-sm font-medium text-gray-700">Konuyu sabitle</span>
                            </label>
                        </div>
                    </div>
                @endcan
                <div>
                    <div class="mb-4">
                        <h4 class="block cursor-default font-medium text-lg md:text-xl text-gray-700">
                            İçeriğiniz
                        </h4>
                        <p class="text-xs lg:text-sm text-gray-500">
                            Konunuzun detaylarını buraya yazabilirsiniz. Markdown desteği bulunmaktadır.
                            Dilerseniz editörün üstündeki butonları kullanarak içeriğinizi zenginleştirebilirsiniz.
                        </p>
                    </div>
                    <x-editor spellcheck="false"></x-editor>
                </div>
                <div class="flex flex-col gap-6">
                    <div class="flex justfiy-between flex-col md:flex-row gap-2 items-center w-full">
                        <div class="flex-grow">
                            <h3 class="block cursor-default text-lg md:text-xl font-medium text-gray-700">
                                Anketler
                            </h3>
                            <p class="text-sm text-gray-500">
                                Gazi Üniversitesi öğrencilerinin fikirlerini almak için konuya özel anketler oluşturun.
                                Taslaklarınız burada görüntülenir.
                            </p>
                        </div>
                        <button type="button" x-on:click="$wire.showCreatePollModal = true"
                            class="mt-2 w-full md:w-fit px-3 py-1.5 text-sm md:text-base hover:bg-teal-500 hover:bg-opacity-5 md:px-4 md:py-2 rounded border border-teal-500 bg-white text-teal-500 font-semibold">
                            Anket Ekle
                        </button>
                    </div>
                    <div x-ref="mainContainer" x-data="pollContainer($wire)" wire:ignore.self
                        class="select-none relative border-2 border-transparent flex flex-col md:flex-row resize-y overflow-hidden active:border-blue-500 active:border-opacity-80 bg-gray-50 rounded-md min-h-[750px] md:min-h-[500px] flex-grow">
                        <div x-ref="activePollsContainer"
                            class="transition-colors duration-200 md:w-1/2 w-full md:border-b-transparent border-b-2 md:border-r-2 border-dashed border-gray-400 flex-grow grid place-items-center">
                            <h1 class="text-lg md:text-xl text-gray-400 font-bold">
                                SEÇİLEN ANKETLER
                            </h1>
                        </div>
                        <div x-ref="draftPollsContainer"
                            class="transition-colors duration-300 md:w-1/2 w-full flex-grow grid place-items-center">
                            <h1 class="text-lg md:text-xl text-gray-400 font-bold">
                                TASLAK ANKETLER
                            </h1>
                        </div>
                        <x-ui.dotted-grid />
                        @forelse ($this->polls as $poll)
                            <div wire:key="poll-{{ $poll->id }}" wire:ignore.self x-ref="poll{{ $poll->id }}"
                                x-data="pollCreator({{ $poll->is_draft ? 'true' : 'false' }})" x-on:mousedown="mouseDown(event)"
                                data-poll="{{ $poll->id }}"
                                class="bg-white select-none shadow-lg transition-opacity duration-300 border-2 cursor-grab rounded-2xl px-4 py-3 w-56 absolute top-0 left-0"
                                :class="{
                                    'animate-wiggle opacity-90 cursor-grabbing scale-105 rotate-2': isDragging,
                                    'border-solid !border-blue-200': !isDraft,
                                    'border-dashed border-gray-200': isDraft
                                }">
                                <div class="flex items-center mb-1.5 justify-between">
                                    <h3 class="text-sm font-bold flex items-center gap-1.5"
                                        :class="{ 'text-blue-500': !isDraft, 'text-amber-600': isDraft }">
                                        <span x-text="pollTitleText"></span>
                                        <div class="size-1.5 rounded-full"
                                            :class="{ 'bg-blue-400': !isDraft, 'bg-amber-400': isDraft }"></div>
                                    </h3>
                                    <div x-on:mousedown.stop x-on:touchstart.stop class="flex items-center gap-0.5">
                                        <button type="button" x-on:click.stop x-on:touchstart.stop x-on:mousedown.stop
                                            wire:click="editPoll({{ $poll->id }})"
                                            class="text-gray-400 hover:text-blue-500 hover:bg-blue-50 p-1.5 rounded-lg transition-colors">
                                            <x-icons.edit size="14" />
                                        </button>
                                        <button type="button" x-on:click.stop x-on:touchstart.stop x-on:mousedown.stop
                                            wire:click="deletePoll({{ $poll->id }})"
                                            class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-colors">
                                            <x-icons.trash size="14" />
                                        </button>
                                    </div>
                                </div>
                                <h5 class="text-gray-700 mb-2 text-sm font-semibold line-clamp-2 leading-relaxed">
                                    {{ $poll->question }}
                                </h5>
                                <div
                                    class="flex flex-col gap-2 max-h-36 overflow-y-auto pr-1.5 scrollbar-thin scrollbar-thumb-gray-200 scrollbar-track-transparent">
                                    @foreach ($poll->options as $index => $option)
                                        <div
                                            class="rounded-xl bg-gray-50/80 border border-gray-100 px-3 py-1 text-gray-600 font-medium hover:border-gray-200 transition-colors">
                                            <span class="text-xs">{{ $option->option }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div
                                class="absolute inset-0 rounded-md font-medium w-full grid place-items-center text-gray-600 ">
                                <div x-on:click="$wire.showCreatePollModal = true"
                                    class="flex flex-col hover:border-teal-300 hover:bg-teal-50 transition duration-300 cursor-pointer justify-center items-center gap-2 p-6 bg-white rounded-md border-2 border-dashed border-gray-400">
                                    <div class="flex items-center gap-2">
                                        <x-icons.survey size="26" />
                                        <span>
                                            Taslak bulunamadı.
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-400 font-normal">
                                        Anket eklemek için <button type="button"
                                            class="text-teal-500 hover:underline">tıklayın.</button>
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="pb-6 w-fit px-6">
                <x-alerts.warning>
                    Konu oluşturduktan sonra yeni anket oluşturamaz veya mevcut anketleri düzenleyemezsiniz.
                </x-alerts.warning>
            </div>
        </div>
    </form>
    <x-poll.create-poll-modal />
    <x-poll.edit-poll-modal :options="$options" :options-count="$optionsCount" :question="$question" />
</div>
