<div>
    <div class="flex items-center gap-1 justify-between w-full border focus:border-gray-300 rounded border-gray-100">
        <input type="text" spellcheck="false" class="outline-none w-full p-2" placeholder="🔎 GIPHY'de Ara" readonly />
        <div class="flex items-end justify-end">
            <a target="_blank" href="https://giphy.com/">
                <img src="{{ asset('logos/giphy.png') }}" alt="Powered by GIPHY" class="w-16 md:w-20" />
            </a>
        </div>
    </div>

    <div class="grid gap-1 grid-cols-4 overflow-y-auto h-[225px] md:h-[350px] mt-2">
        @for ($i = 0; $i < 12; $i++)
            <div class="flex items-center justify-center">
                <img src="{{ asset('placeholder.svg') }}" alt="Loading..."
                    class="h-16 md:h-32 object-cover rounded-md" />
            </div>
        @endfor
    </div>
</div>
