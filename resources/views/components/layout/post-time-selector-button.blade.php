@props(['timeSpan' => 'all', 'displayText' => 'Tüm Zamanlar'])
<button
    x-on:click="$dispatch('time-span-selected', { timeSpan: '{{ $timeSpan }}' }); timeSelectorDropdown = false; displayText=$el.innerText"
    type="button"
    class="text-sm flex items-center gap-2 md:gap-3 md:text-base py-3 px-2.5 md:py-4 hover:bg-gray-50 md:px-3 text-left text-gray-800 font-normal">
    <x-icons.time size="18" class="text-gray-600" />
    {{ $displayText }}
</button>
