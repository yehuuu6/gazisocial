@push('scripts')
    @vite('resources/js/editor.js')
    @vite('resources/js/poll-creator.js')
@endpush
<div x-data="{
    openPollCreator: false,
    optionsCount: $wire.entangle('optionsCount'),
    options: $wire.entangle('options'),
    saveOptions() {
        this.options = [];
        const optionValues = document.querySelectorAll('[data-option]');
        optionValues.forEach((option) => {
            this.options.push(option.value);
        });
        $wire.call('createPoll');
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
                class="flex items-center justify-between gap-4 sticky z-[2] bg-white px-6 rounded-t-xl py-4 border-b border-gray-200">
                <h1 class="text-base md:text-xl flex items-center gap-2 font-bold text-gray-800">
                    <div class="size-4 md:size-6 rounded-sm bg-gradient-to-t from-blue-500 to-blue-300">
                    </div>
                    Yeni Konu Oluştur
                </h1>
                <div class="flex items-center gap-3">
                    <button type="button"
                        class="px-3 py-1.5 text-sm md:text-base md:px-4 md:py-2 rounded bg-gray-200 text-gray-800 font-medium hover:bg-gray-300">
                        Önizleme
                    </button>
                    <button type="button" wire:click="createPost"
                        class="px-3 py-1.5 text-sm md:text-base md:px-4 md:py-2 rounded bg-primary bg-opacity-90 hover:bg-opacity-100 text-white font-semibold">
                        Oluştur
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-5 md:gap-7 p-6">
                <div class="flex flex-col md:flex-row gap-3 md:gap-6">
                    <div class="w-full md:w-[300px]">
                        <label for="title" class="block text-lg md:text-xl font-medium text-gray-700">
                            Konu Başlığı
                        </label>
                        <p class="text-sm text-gray-500">
                            Dikkat çekici ve anlaşılır bir başlık kullanıcıların konunuza daha fazla ilgi göstermesini
                            sağlar.
                        </p>
                    </div>
                    <textarea wire:model="title" id="title" name="title" rows="1" spellcheck="false"
                        class="flex-grow px-4 py-2 text-lg font-medium text-gray-800 bg-gray-50 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-80 resize-none"
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
                        <p class="text-sm text-gray-500">
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
                                    'bg-opacity-100' :
                                    'bg-opacity-40'"
                                class="rounded-full hover:bg-opacity-80 px-2.5 py-1 text-white bg-{{ $tag->color }}-500 shadow-sm focus:outline-none text-sm active:scale-90 transition-transform duration-100">
                                {{ $tag->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div class="mb-4">
                        <h4 class="block cursor-default font-medium text-lg md:text-xl text-gray-700">
                            İçeriğiniz
                        </h4>
                        <p class="text-sm text-gray-500">
                            Konunuzun detaylarını buraya yazabilirsiniz. <button type="button"
                                class="outline-none hover:underline border-none bg-transparent text-blue-500"
                                x-on:click="alert('Not implemented yet!')">Markdown</button> desteği bulunmaktadır.
                            Dilerseniz editörün üstündeki butonları kullanarak içeriğinizi zenginleştirebilirsiniz.
                        </p>
                    </div>
                    <x-editor spellcheck="false"></x-editor>
                </div>
                <div class="flex flex-col gap-6">
                    <div class="w-full">
                        <h3 class="block cursor-default text-lg md:text-xl font-medium text-gray-700">
                            Anketler
                        </h3>
                        <p class="text-sm text-gray-500">
                            Gazi Üniversitesi öğrencilerinin fikirlerini almak için konuya özel anketler oluşturun.
                            Taslaklarınız burada görüntülenir.
                        </p>
                        <button type="button" x-on:click="openPollCreator = true"
                            class="mt-2 px-3 py-1.5 text-sm md:text-base md:px-4 md:py-2 rounded bg-primary bg-opacity-90 hover:bg-opacity-100 text-white font-semibold">
                            Anket Oluştur
                        </button>
                    </div>
                    <div x-ref="mainContainer" x-data="pollContainer($wire)" wire:ignore.self
                        class="select-none relative border-2 border-transparent flex flex-col md:flex-row resize-y overflow-auto active:border-blue-500 active:border-opacity-80 bg-gray-50 rounded-md min-h-[750px] md:min-h-[500px] flex-grow">
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
                                x-data="pollCreator({{ $poll->is_draft ? 'true' : 'false' }})" x-on:mousedown="mouseDown(event)" x-on:mouseup="mouseUp()"
                                x-on:mousemove="mouseMove(event)" data-poll="{{ $poll->id }}"
                                class="bg-white select-none shadow transition-opacity duration-500 border-2 cursor-grab rounded-md px-2 py-1 w-40 absolute top-0 left-0"
                                :class="{
                                    'animate-wiggle opacity-80 cursor-grabbing': isDragging,
                                    'border-solid border-blue-300': !isDraft,
                                    'border-dashed border-gray-200': isDraft
                                }">
                                <div class="flex items-center mb-1 justify-between">
                                    <h3 class="text-gray-800 text-sm font-bold" x-text="pollTitleText">

                                    </h3>
                                    <button type="button" wire:click="deletePoll({{ $poll->id }})"
                                        class="text-red-500 hover:text-red-600">
                                        <x-icons.trash size="12" />
                                    </button>
                                </div>
                                <h5 class="text-gray-700 mb-2 text-xs font-medium">
                                    {{ $poll->question }}
                                </h5>
                                <div class="flex flex-col gap-2.5 max-h-24 overflow-y-auto">
                                    @foreach ($poll->options as $option)
                                        <div
                                            class="rounded border border-gray-200 px-1 py-0.5 text-gray-700 font-normal">
                                            <span class="text-xs">{{ $option->option }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div
                                class="absolute inset-0 rounded-md font-medium w-full grid place-items-center text-gray-600 ">
                                <div x-on:click="openPollCreator = true"
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
                    Konu oluşturduktan sonra yeni anket oluşturamaz ve mevcut anketleri düzenleyemezsiniz.
                </x-alerts.warning>
            </div>
        </div>
    </form>
    <x-poll.create-poll-modal wire:modal="openPollCreator" x-on:poll-draft-created.window="openPollCreator = false" />
</div>
