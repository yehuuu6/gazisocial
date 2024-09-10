<div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden">
    <x-header-title>
        Konu Oluştur
    </x-header-title>
    <x-seperator />
    <x-scrollable-wrapper class="h-full">
        <form wire:submit="createPost" enctype="multipart/form-data">
            <div class="p-6 space-y-4">
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Başlık</label>
                    <input wire:model="title" type="text" id="title" name="title"
                        class="bg-gray-100 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
                <div class="space-y-2">
                    <label for="content" class="block text-sm font-medium text-gray-700">İçerik</label>
                    <textarea wire:model="content" id="content" name="content" rows="5"
                        class="bg-gray-100 resize-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                </div>
                <div class="space-y-2">
                    <label for="tags" class="block text-sm font-medium text-gray-700">Etiketler</label>
                    <div id="tags" class="flex flex-wrap gap-2">
                        @foreach ($tags as $tag)
                            <button wire:click="toggleTag('{{ $tag->id }}')" type="button"
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
                <h3 class="text-sm block font-medium text-gray-700">Anketler</h3>

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
                <div class="flex gap-2 justify-end">
                    <button type="button"
                        wire:click="$dispatch('openModal', { component: 'modals.create-poll-modal' })"
                        class="py-2 px-5 border border-green-500 outline-none bg-transparent text-green-500 font-medium hover:bg-green-500 hover:text-white rounded outline:none">
                        Anket Ekle
                    </button>
                    <button type="submit" wire:loading.class='animate-pulse'
                        class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 outline-none">
                        Yayınla
                    </button>
                </div>
            </div>
        </form>
    </x-scrollable-wrapper>
</div>
