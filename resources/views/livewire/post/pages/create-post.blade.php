@push('scripts')
    @vite('resources/js/editor.js')
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
                class="flex items-center justify-between gap-4 sticky z-[1] bg-white px-6 rounded-t-xl py-4 border-b border-gray-200">
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
                    <button type="button"
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
                            <button
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
                <div class="flex flex-col md:flex-row gap-3 md:gap-6">
                    <div class="w-full md:w-[300px] shrink-0">
                        <h3 class="block cursor-default text-lg md:text-xl font-medium text-gray-700">
                            Anketler
                        </h3>
                        <p class="text-sm text-gray-500">
                            Gazi Üniversitesi öğrencilerinin fikirlerini almak için konuya özel anketler oluşturun.
                            Taslaklarınız burada görüntülenir.
                        </p>
                    </div>
                    <div
                        class="border-2 border-transparent active:border-blue-500 active:border-opacity-80 bg-gray-50 p-4 rounded-md min-h-64 grid gap-4 md:[grid-template-columns:repeat(auto-fit,minmax(300px,1fr))] flex-grow">
                        @forelse ($this->polls as $poll)
                            <div class="bg-white border border-gray-200 rounded-md px-6 py-4">
                                <div class="flex items-center gap-2 justify-between">
                                    <h5 class="text-gray-700 mb-2 text-lg font-medium">
                                        {{ $poll->question }}
                                    </h5>
                                    <button type="button" wire:click="deletePoll({{ $poll->id }})"
                                        class="text-red-500 hover:text-red-600">
                                        <x-icons.trash size="18" />
                                    </button>
                                </div>
                                <div class="flex flex-col gap-2.5">
                                    @foreach ($poll->options as $option)
                                        <div
                                            class="bg-gray-50 rounded border border-gray-200 px-4 py-2 text-gray-700 text-base font-normal hover:bg-gray-100">
                                            <span>{{ $option->option }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="h-full rounded-md font-medium w-full grid place-items-center text-gray-600 ">
                                <div x-on:click="openPollCreator = true"
                                    class="flex flex-col hover:border-teal-300 hover:bg-teal-50 transition duration-300 cursor-pointer justify-center items-center gap-2 p-6 bg-white rounded-md border-2 border-dashed border-gray-200">
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
