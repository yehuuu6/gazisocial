<div x-data="{
    isHome: '{{ request()->routeIs('home') }}',
}" class="mx-[3%] mt-4 md:mx-[6%] md:mt-8 lg:mx-[12%]">
    <header class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between md:gap-0">
        <div class="flex items-center justify-between gap-1 md:justify-start">
            <livewire:tag.tags-lister lazy="on-load" :displayName="request()->route('tag')->name ?? null" :displayColor="request()->route('tag')->color ?? null" />
            <a :class="{
                'text-primary bg-blue-300 bg-opacity-30': isHome,
                'text-gray-700 bg-gray-200 bg-opacity-0 hover:bg-opacity-65': !isHome
            }"
                wire:navigate.hover href="/"
                class="rounded ml-2.5 px-4 py-2 font-medium text-sm hover:no-underline">
                Giriş
            </a>
            <a :class="{
                'text-primary bg-blue-300 bg-opacity-30': false,
                'text-gray-700 bg-gray-200 bg-opacity-0 hover:bg-opacity-65': true
            }"
                wire:navigate.hover href="{{ route('posts.index') }}"
                class="rounded px-4 py-2 font-medium text-sm hover:no-underline">
                En Yeni
            </a>
            <a :class="{
                'text-primary bg-blue-300 bg-opacity-30': false,
                'text-gray-700 bg-gray-200 bg-opacity-0 hover:bg-opacity-65': true
            }"
                wire:navigate.hover href="{{ route('posts.index') }}"
                class="rounded px-4 py-2 font-medium text-sm hover:no-underline">
                Popüler
            </a>
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
            <button x-on:click="alert('Not implemented yet!')" type="button"
                class="rounded-full p-3 hover:bg-white hover:shadow">
                <x-icons.search size="24" class="text-primary" />
            </button>
        </div>
    </header>
</div>
