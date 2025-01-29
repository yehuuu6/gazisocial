<div class="mt-4 md:mt-8 w-fit" x-data="{ displayText: 'Tüm Zamanlar', timeSelectorDropdown: false }">
    <div x-ref="timeSpanAnchor">
        <x-ui.tooltip text="Zaman Aralığı" position="right" delay="500">
            <button type="button" x-on:click="timeSelectorDropdown = !timeSelectorDropdown"
                class="pr-2 flex items-center gap-2 text-base md:text-lg text-gray-800 font-semibold">
                <span class="font-semibold" x-text="displayText">Tüm Zamanlar</span>
                <x-icons.arrow-down size="20" x-show="!timeSelectorDropdown" />
                <x-icons.arrow-up size="20" x-cloak x-show="timeSelectorDropdown" />
            </button>
        </x-ui.tooltip>
    </div>
    <div x-cloak x-show="timeSelectorDropdown" x-anchor.offset.5.bottom-start="$refs.timeSpanAnchor"
        x-transition.origin.top.left x-on:click.away="timeSelectorDropdown = false;"
        class="overflow-y-auto flex text-left flex-col w-44 max-h-72 md:w-64 md:max-h-96 bg-white rounded-md shadow">
        <x-layout.post-time-selector-button timeSpan="all" displayText="Tüm Zamanlar" />
        <x-layout.post-time-selector-button timeSpan="one_year" displayText="Son bir yıl" />
        <x-layout.post-time-selector-button timeSpan="six_months" displayText="Son altı ay" />
        <x-layout.post-time-selector-button timeSpan="this_month" displayText="Son bir ay" />
        <x-layout.post-time-selector-button timeSpan="this_week" displayText="Son bir hafta" />
        <x-layout.post-time-selector-button timeSpan="today" displayText="Bugün" />
    </div>
</div>
