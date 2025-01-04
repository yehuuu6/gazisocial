<div>
    <button x-ref="timeToggle" title="Zaman Aralığı içinde" @click="open = !open"
        x-on:time-period-updated.window="open = false"
        class="ml-2 flex items-center gap-2 rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow">
        {{ $text }}
        <template x-if="open">
            <x-icons.arrow-up size="12" />
        </template>
        <template x-if="!open">
            <x-icons.arrow-down size="12" />
        </template>
    </button>
    <div x-cloak x-show="open" @click.away="open = false" x-collapse x-anchor.bottom-start="$refs.timeToggle"
        class="z-10 mt-1 w-[225px] gap-0.5 whitespace-nowrap rounded-lg border border-gray-200 bg-white shadow-md md:w-[250px] lg:w-[275px]">
        <div class="flex flex-col gap-1 p-2">
            <button wire:click="setTimePeriod('today')"
                class="flex items-center gap-2 rounded-md px-2 py-1 text-sm font-normal capitalize hover:bg-[#E5E7EB]/50 hover:no-underline">
                <x-icons.time size="20" color="gray" /> Bugün
            </button>
            <button wire:click="setTimePeriod('one_week')"
                class="flex items-center gap-2 rounded-md px-2 py-1 text-sm font-normal capitalize hover:bg-[#E5E7EB]/50 hover:no-underline">
                <x-icons.time size="20" color="gray" /> Bir Hafta
            </button>
            <button wire:click="setTimePeriod('three_months')"
                class="flex items-center gap-2 rounded-md px-2 py-1 text-sm font-normal capitalize hover:bg-[#E5E7EB]/50 hover:no-underline">
                <x-icons.time size="20" color="gray" /> Üç Ay
            </button>
            <button wire:click="setTimePeriod('six_months')"
                class="flex items-center gap-2 rounded-md px-2 py-1 text-sm font-normal capitalize hover:bg-[#E5E7EB]/50 hover:no-underline">
                <x-icons.time size="20" color="gray" /> Altı Ay
            </button>
            <button wire:click="setTimePeriod('one_year')"
                class="flex items-center gap-2 rounded-md px-2 py-1 text-sm font-normal capitalize hover:bg-[#E5E7EB]/50 hover:no-underline">
                <x-icons.time size="20" color="gray" /> Bir Yıl
            </button>
            <button wire:click="setTimePeriod('all_time')"
                class="flex items-center gap-2 rounded-md px-2 py-1 text-sm font-normal capitalize hover:bg-[#E5E7EB]/50 hover:no-underline">
                <x-icons.time size="20" color="gray" /> Tüm Zamanlar
            </button>
        </div>
    </div>

</div>
