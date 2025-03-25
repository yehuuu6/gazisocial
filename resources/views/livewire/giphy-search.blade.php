<div>
    <div class="flex items-center gap-1 justify-between w-full border focus:border-gray-300 rounded border-gray-100">
        <input x-trap="gifSelector" type="text" spellcheck="false" class="text-sm lg:text-lg outline-none w-full p-2"
            placeholder="🔎 GIPHY'de Ara" wire:model.live.debounce.500ms="query" id="giphy-search-input" />
        <div class="flex items-end justify-end">
            <a target="_blank" href="https://giphy.com/">
                <img src="{{ asset('logos/giphy.png') }}" alt="Powered by GIPHY" class="w-16 md:w-20" />
            </a>
        </div>
    </div>
    <div class="h-[225px] md:h-[350px] mt-2" wire:loading.flex>
        <div class="flex items-center justify-center h-full w-full">
            <x-icons.spinner size="16" class="text-primary size-12 lg:size-20" />
        </div>
    </div>
    <div class="grid gap-1 grid-cols-2 lg:grid-cols-4 overflow-y-auto h-[225px] md:h-[350px] mt-2" wire:loading.remove>
        @foreach ($this->gifs as $gif)
            <img src="{{ $gif['images']['fixed_height']['url'] }}" alt="GIF" x-on:click="gifSelector = false"
                class="h-16 md:h-32 w-full object-cover rounded-md cursor-pointer"
                wire:click="$parent.sendGif('{{ $gif['images']['original']['url'] }}')" loading="lazy" />
        @endforeach
    </div>

</div>
