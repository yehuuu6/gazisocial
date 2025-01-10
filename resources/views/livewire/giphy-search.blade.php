<div>
    <input x-trap="gifSelector" type="text" spellcheck="false"
        class="w-full border border-gray-100 rounded outline-none focus:border-gray-300 p-2 bg-gray-50"
        placeholder="GIPHY'de Ara" wire:model.live.debounce.500ms="query" />

    @if (!empty($this->gifs))
        <div class="grid grid-cols-2 gap-1 md:grid-cols-4 overflow-y-auto h-[350px] mt-2">
            @foreach ($this->gifs as $gif)
                <img src="{{ $gif['images']['fixed_height']['url'] }}" alt="GIF" x-on:click="gifSelector = false"
                    class="h-32 object-cover rounded-md cursor-pointer"
                    wire:click="selectGif('{{ $gif['images']['original']['url'] }}')" loading="lazy" />
            @endforeach
        </div>
    @endif
</div>
