@props(['timeSpan' => 'all', 'displayText' => 'Tüm Zamanlar'])
<button
    x-on:click="$dispatch('time-span-selected', { timeSpan: '{{ $timeSpan }}' }); timeSelectorDropdown = false; displayText=$el.innerText"
    type="button" class="flex items-center gap-4 w-full px-5 py-4 text-sm font-medium text-gray-700 hover:bg-gray-100">
    <x-icons.time size="18" class="text-gray-600" />
    {{ $displayText }}
</button>
