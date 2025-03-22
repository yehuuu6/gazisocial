@push('scripts')
    @vite('resources/js/editor.js')
@endpush
<div>
    <form wire:submit="updatePost" class="rounded-xl border border-gray-100 bg-white shadow-md">
        <div class="flex-grow">
            <div wire:ignore x-data="{ navbarHeight: 0 }" x-init="navbarHeight = document.getElementById('navbar').offsetHeight;
            $el.style.top = navbarHeight + 'px';"
                class="flex items-center justify-between gap-4 sticky z-[2] bg-white px-4 lg:px-6 rounded-t-xl py-2.5 lg:py-4 border-b border-gray-200">
                <h1 class="text-base md:text-xl flex items-center gap-2 font-bold text-gray-800">
                    <div class="size-4 md:size-6 rounded-sm bg-gradient-to-t from-blue-500 to-blue-300 flex-shrink-0">
                    </div>
                    Konuyu Düzenle
                </h1>
                <div class="flex items-center gap-2">
                    <a href="{{ $post->showRoute() }}"
                        class="px-3 py-1.5 text-xs lg:text-base md:px-4 md:py-2 rounded border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-50">
                        İptal
                    </a>
                    <button type="button" wire:click="updatePost"
                        class="px-3 py-1.5 text-xs lg:text-base md:px-4 md:py-2 rounded bg-primary bg-opacity-90 hover:bg-opacity-100 text-white font-semibold">
                        Güncelle
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-5 md:gap-7 p-4 lg:p-6">
                <div class="w-fit">
                    @php
                        $isAdmin = Auth::user()->canDoHighLevelAction();
                        $isAuthor = $post->user_id === Auth::id();
                        $isAnonymous = $post->isAnonim();
                    @endphp

                    {{-- Alert for admin editing another user's non-anonymous post --}}
                    @if (!$isAnonymous && !$isAuthor && $isAdmin)
                        <x-alerts.warning>
                            Bu konu <a wire:navigate href="{{ route('users.show', $post->user->username) }}"
                                class="font-bold text-amber-500 underline">{{ $post->user->name }}</a> tarafından
                            oluşturulmuştur. Yönetici yetkinizle düzenleme yapıyorsunuz.
                        </x-alerts.warning>
                    @endif

                    {{-- Alert for author editing their own anonymous post --}}
                    @if ($isAnonymous && $isAuthor)
                        <x-alerts.warning>
                            Bu konuyu anonim olarak oluşturdunuz. Anonimlik kaldırılamaz ancak konunuzu
                            düzenleyebilirsiniz.
                        </x-alerts.warning>
                        {{-- Alert for admin editing another user's anonymous post --}}
                    @elseif ($isAnonymous && $isAdmin && !$isAuthor)
                        <x-alerts.warning>
                            Bu konu anonim olarak <x-link href="{{ route('users.show', $post->user->username) }}"
                                class="font-bold text-amber-500 underline">{{ $post->user->name }}</x-link> tarafından
                            oluşturulmuştur. Yönetici olarak düzenleme yapıyorsunuz.
                        </x-alerts.warning>
                    @endif
                </div>
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
            </div>
            <div wire:dirty class="pb-6 w-fit px-6">
                <x-alerts.warning>
                    Kaydedilmemiş değişiklikleriniz var. Değişikliklerinizi kaydetmek için "Güncelle" butonuna tıklayın.
                </x-alerts.warning>
            </div>
        </div>
    </form>
</div>
