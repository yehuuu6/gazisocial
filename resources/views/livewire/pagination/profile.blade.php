<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-5 px-6">
            <span>
                @if ($paginator->onFirstPage())
                    <span
                        class="relative inline-flex items-center p-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-full">
                        <x-tabler-chevron-left class="size-5" />
                    </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev"
                        class="relative inline-flex items-center p-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-full hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        <x-tabler-chevron-left class="size-5" />
                    </button>
                @endif
            </span>

            <span>
                @if ($paginator->onLastPage())
                    <span
                        class="relative inline-flex items-center p-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-full">
                        <x-tabler-chevron-right class="size-5" />
                    </span>
                @else
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next"
                        class="relative inline-flex items-center p-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-full hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        <x-tabler-chevron-right class="size-5" />
                    </button>
                @endif
            </span>
        </nav>
    @endif
</div>
