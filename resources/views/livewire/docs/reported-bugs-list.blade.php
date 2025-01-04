<div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
    <div class="flex items-center justify-between m-6 mb-0">
        <h1 class="text-3xl font-bold text-gray-900">Rapor Edilmiş Hatalar</h1>
        <div class="flex items-center gap-1 relative" x-data="{ open: false }">
            <button x-ref="bugFilterToggle" @click="open = !open"
                class="rounded-md px-3 py-2 border-gray-200 text-gray-700 text-sm border flex items-center gap-0.5">
                <x-icons.filter size="14" />
                <span class="mx-1">Filtrele</span>
                <template x-if="open">
                    <x-icons.arrow-up size="12" />
                </template>
                <template x-if="!open">
                    <x-icons.arrow-down size="12" />
                </template>
            </button>
            <div x-cloak x-show="open" @click.away="open = false" x-transition.origin.top.right.duration.200ms
                x-anchor.bottom-start="$refs.bugFilterToggle"
                class="z-10 mt-1 gap-0.5 w-full min-w-max whitespace-nowrap shadow-sm rounded-lg border border-gray-200 bg-white">
                <div class="flex flex-col gap-1 p-1.5">
                    <button wire:click="filterBugs('pending')" @click="open = false"
                        class="flex @if ($bugFilterType === 'pending') bg-gray-100 @endif text-gray-600 items-center gap-2 rounded-md px-4 py-2 text-sm font-normal capitalize hover:bg-gray-50 hover:no-underline">
                        Beklemede
                    </button>
                    <button wire:click="filterBugs('resolved')" @click="open = false"
                        class="flex @if ($bugFilterType === 'resolved') bg-gray-100 @endif text-gray-600 items-center gap-2 rounded-md px-4 py-2 text-sm font-normal capitalize hover:bg-gray-50 hover:no-underline">
                        Çözüldü
                    </button>
                    <button wire:click="filterBugs('all')" @click="open = false"
                        class="flex @if ($bugFilterType === 'all') bg-gray-100 @endif text-gray-600 items-center gap-2 rounded-md px-4 py-2 text-sm font-normal capitalize hover:bg-gray-50 hover:no-underline">
                        Tümünü Göster
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-2 p-4">
        @forelse ($bugs as $bug)
            <div class="flex justify-between md:items-center rounded-md border border-gray-200 bg-gray-50 p-4 gap-10">
                <div class="flex flex-col gap-1">
                    <x-link href="{{ route('show-bug', $bug) }}"
                        class="text-lg font-medium">{{ $bug->title }}</x-link>
                    <p class="text-sm text-gray-600"><x-link class="text-blue-400"
                            href="{{ route('users.show', $bug->user->username) }}">{{ $bug->user->name }}</x-link>
                        tarafından
                        {{ $bug->created_at->locale('tr')->diffForHumans() }} bildirildi.</p>
                </div>
                <span
                    class="border {{ $this->getBadge($bug->status) }} self-start px-4 py-2 rounded-md text-sm font-light">
                    @php
                        if ($bug->status === 'pending') {
                            echo 'Beklemede';
                        } else {
                            echo 'Çözüldü';
                        }
                    @endphp
                </span>
            </div>
        @empty
            <div class="rounded-md shadow p-4">
                <p class="text-sm text-gray-600">Harika! Şu ana kadar hiç bildirilen hata yok.</p>
            </div>
        @endforelse
    </div>
    {{ $bugs->links('livewire.pagination.simple') }}
</div>
