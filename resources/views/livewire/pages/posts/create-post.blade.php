<div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden">
    <x-header-title>
        Konu Oluştur
    </x-header-title>
    <x-seperator />
    <form wire:submit="createPost" enctype="multipart/form-data" class="flex flex-col h-full">
        <x-scrollable-wrapper class="flex-grow">
            <div class="flex flex-col gap-5 py-4">
                <div class="flex flex-col gap-2 px-4">
                    <label for="title" class="block font-medium text-gray-700">Başlık</label>
                    <input wire:model="title" type="text" id="title" name="title" maxlength="100" minlength="6"
                        required
                        class="block w-full bg-gray-50 px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                <div class="flex flex-col gap-2 px-4">
                    <label for="content" class="block font-medium text-gray-700">İçerik</label>
                    <x-editor wire:model.live="content"></x-editor>
                    <textarea wire:model="content" id="content" name="content" rows="22" maxlength="5000" minlength="10" required
                        spellcheck="false"
                        class="bg-gray-50 block resize-none w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
                <div class="flex flex-col gap-2 px-4">
                    <h3 class="cursor-default block font-medium text-gray-700">Etiketler</h3>
                    <div id="tags" class="flex flex-wrap gap-2">
                        @foreach ($tags as $tag)
                            <button wire:click="toggleTag('{{ $tag->id }}')" type="button" wire:target="toggleTag"
                                wire:key="tag-toggler-{{ $tag->id }}" wire:loading.attr="disabled"
                                wire:loading.class="animate-pulse"
                                class="px-3 py-1 flex items-center gap-1 rounded-full shadow-sm focus:outline-none sm:text-sm
                                {{ in_array($tag->id, $selectedTags) ? 'bg-indigo-500 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                                @if (in_array($tag->id, $selectedTags))
                                    <x-icons.minus color='white' size='14' />
                                @else
                                    <x-icons.plus color='#6366f1' size='14' />
                                @endif

                                {{ $tag->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col gap-2 px-4">
                    <h3 class="cursor-default block font-medium text-gray-700">Anketler</h3>
                    <div class="flex gap-5">
                        @foreach ($createdPolls as $poll)
                            <div class="flex flex-col flex-grow gap-1 rounded-md border border-gray-300 bg-gray-100">
                                <div class="flex items-center justify-between py-2 px-4">
                                    <h3 class="text-md text-gray-700 font-medium">{{ $poll['question'] }}</h3>
                                    <button wire:click.prevent="removePoll({{ $loop->index }})" type="button">
                                        <x-icons.trash color='#ff6969' size='16' />
                                    </button>
                                </div>
                                <x-seperator />
                                <div class="flex flex-col gap-2 py-1 pb-3">
                                    @foreach ($poll['options'] as $option)
                                        <div class="flex items-center px-2 gap-1">
                                            <span
                                                class="px-3 py-2 bg-gray-200 rounded-full w-full text-gray-700">{{ $option }}</span>
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
        </x-scrollable-wrapper>
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
