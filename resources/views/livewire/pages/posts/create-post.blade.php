<div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden border border-gray-100">
    <form wire:submit="createPost" enctype="multipart/form-data" class="flex flex-col h-full">
        <div class="flex-grow">
            <div class="flex flex-col gap-5 py-4">
                <div class="flex flex-col gap-2 px-4">
                    <label for="title" class="block font-medium text-gray-700">Başlık</label>
                    <input wire:model="title" type="text" id="title" name="title" maxlength="100" minlength="6"
                        required
                        class="block w-full bg-gray-50 px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                <div class="flex flex-col gap-2 px-4">
                    <label for="content" class="block font-medium text-gray-700">İçerik</label>
                    <x-editor wire:model="content"></x-editor>
                </div>
                <div x-data="{ selectedTags: $wire.selectedTags }" class="flex flex-col gap-2 px-4">
                    <label for="tags" class="cursor-default block font-medium text-gray-700">Etiketler</label>
                    <input type="hidden" name="tags" id="tags" wire:model='selectedTags'>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($tags as $tag)
                            <button
                                x-on:click="selectedTags.includes({{ $tag->id }}) ? selectedTags.splice(selectedTags.indexOf({{ $tag->id }}), 1) : selectedTags.push({{ $tag->id }})"
                                type="button"
                                x-bind:class="selectedTags.includes({{ $tag->id }}) ? 'bg-indigo-500 text-white' :
                                    'bg-gray-100 hover:bg-gray-200 text-gray-700'"
                                class="px-3 py-1 flex items-center gap-1 rounded-full shadow-sm focus:outline-none sm:text-sm">
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
                <div class="flex flex-col gap-2 px-4">
                    <h3 class="cursor-default block font-medium text-gray-700">Anketler</h3>
                    <div class="flex gap-5">
                        @foreach ($createdPolls as $poll)
                            <div class="flex flex-col flex-grow gap-1 border border-gray-300 p-4 shadow-sm rounded-md">
                                <div class="flex flex-col gap-2">
                                    <h3 class="text-xl text-gray-700 font-medium">
                                        {{ $poll['question'] }}</h3>
                                    @foreach ($poll['options'] as $option)
                                        <div wire:key="option-{{ $loop->index }}"
                                            class="flex justify-between items-center transition-all duration-500 py-2 gap-1 px-3 bg-gray-50 rounded-md border-2 border-gray-200">
                                            <div class="flex flex-col flex-grow pb-1 px-1">
                                                <div class="flex items-center">
                                                    <div class="flex items-center cursor-pointer w-full">
                                                        <input type="radio" id="option-input-{{ $loop->index }}"
                                                            name="option" readonly class="size-4">
                                                        <label for="option-input-{{ $loop->index }}"
                                                            class="ml-2 cursor-pointer flex-1 flex items-center justify-between">
                                                            <span class="text-gray-700">{{ $option }}</span>
                                                            <span class="text-gray-500">0%</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="w-full bg-gray-300 rounded-full h-2 mt-2">
                                                    <div
                                                        class="bg-blue-600 h-2 rounded-full transition-all duration-1000">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if (count($createdPolls) === 0)
                        <h3 class="text-gray-500">Hiç anket eklenmemiş.</h3>
                    @else
                        <h3 class="text-orange-400">Oluşturduğunuz anketler taslaktır ve konuyu
                            yayınlamadığınız
                            sürece görünmeyecektir.</h3>
                    @endif
                </div>

            </div>
        </div>
        <x-seperator />
        <div class="flex justify-end bg-gray-50 p-6 gap-4">
            <button type="button" wire:click="$dispatch('openModal', { component: 'modals.create-poll-modal' })"
                class="px-6 py-2 border border-green-500 outline-none bg-transparent text-green-500 font-medium hover:bg-green-500 hover:text-white rounded outline:none">
                Anket Ekle
            </button>
            <button type="submit" wire:loading.class='animate-pulse' wire:loading.attr='disabled'
                wire:target='createPost'
                class="px-6 py-2 bg-blue-500 text-white font-medium rounded hover:bg-blue-600 outline-none">
                Yayınla
            </button>
        </div>
    </form>
</div>
