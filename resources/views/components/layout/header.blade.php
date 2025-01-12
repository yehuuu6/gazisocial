<div class="mx-[3%] mt-4 md:mx-[6%] md:mt-8 lg:mx-[12%]">
    <header class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between md:gap-0">
        <div class="flex items-center justify-between gap-3 md:justify-start">
            <livewire:tag.tags-lister lazy :displayName="request()->route('tag')->name ?? null" :displayColor="request()->route('tag')->color ?? null" />
            <div x-data="{ selectedSortMethod: 'newest' }">
                <div class="flex items-center gap-2">
                    <button type="button" x-on:click="selectedSortMethod = 'newest'"
                        :class="{
                            'text-primary bg-blue-300 bg-opacity-30': selectedSortMethod === 'newest',
                            'text-gray-700 bg-gray-200 bg-opacity-0 hover:bg-opacity-65': selectedSortMethod !== 'newest'
                        }"
                        class="rounded px-4 py-2 font-medium text-sm">
                        En Yeni
                    </button>
                    <button type="button" x-on:click="selectedSortMethod = 'popular'"
                        :class="{
                            'text-primary bg-blue-300 bg-opacity-30': selectedSortMethod === 'popular',
                            'text-gray-700 bg-gray-200 bg-opacity-0 hover:bg-opacity-65': selectedSortMethod !== 'popular'
                        }"
                        class="rounded px-4 py-2 font-medium text-sm">
                        Popüler
                    </button>
                </div>
            </div>
        </div>
        <div class="hidden items-center gap-2 md:flex">
            <x-link href="{{ route('posts.create') }}"
                class="rounded bg-primary border border-primary px-3 py-2 text-sm font-medium text-white bg-opacity-90 hover:bg-opacity-100 hover:no-underline">
                Yeni Konu Oluştur
            </x-link>
            @can('join', App\Models\Faculty::class)
                @if (!Auth::user()->faculty)
                    <x-link href="{{ route('faculties') }}"
                        class="rounded border border-primary px-3 py-2 text-sm font-medium text-primary text-opacity-90 hover:text-opacity-100 hover:no-underline">
                        Fakülteye Katıl
                    </x-link>
                @endif
            @endcan
        </div>
    </header>
</div>
