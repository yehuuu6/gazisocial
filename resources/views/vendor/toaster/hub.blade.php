<div role="status" id="toaster" x-data="toasterHub(@js($toasts), @js($config))" @class([
    'fixed z-50 p-4 w-full flex flex-col pointer-events-none sm:p-6',
    'bottom-0' => $alignment->is('bottom'),
    'top-1/2 -translate-y-1/2' => $alignment->is('middle'),
    'top-0' => $alignment->is('top'),
    'items-start rtl:items-end' => $position->is('left'),
    'items-center' => $position->is('center'),
    'items-end rtl:items-start' => $position->is('right'),
])>
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.isVisible" x-init="$nextTick(() => toast.show($el))" @if ($alignment->is('bottom'))
            x-transition:enter-start="translate-y-12 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
        @elseif($alignment->is('top'))
            x-transition:enter-start="-translate-y-12 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
        @else
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            @endif
            x-transition:leave-end="opacity-0 scale-90"
            class="relative group duration-300 transform transition ease-in-out max-w-sm md:max-w-md w-full pointer-events-auto"
            >
            <div
                class="flex border border-gray-100 gap-0.5 items-center bg-white px-6 py-4 rounded-md shadow-lg text-sm w-full {{ $alignment->is('bottom') ? 'mt-3' : 'mb-3' }}">
                <svg x-show="toast.type=='success'" class="shrink-0 size-6 md:size-8 mr-1.5 -ml-1 text-green-500"
                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM16.7744 9.63269C17.1238 9.20501 17.0604 8.57503 16.6327 8.22559C16.2051 7.87615 15.5751 7.93957 15.2256 8.36725L10.6321 13.9892L8.65936 12.2524C8.24484 11.8874 7.61295 11.9276 7.248 12.3421C6.88304 12.7566 6.92322 13.3885 7.33774 13.7535L9.31046 15.4903C10.1612 16.2393 11.4637 16.1324 12.1808 15.2547L16.7744 9.63269Z"
                        fill="currentColor"></path>
                </svg>
                <svg x-show="toast.type=='info'" class="shrink-0 size-6 md:size-8 mr-1.5 -ml-1 text-blue-500"
                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM12 9C12.5523 9 13 8.55228 13 8C13 7.44772 12.5523 7 12 7C11.4477 7 11 7.44772 11 8C11 8.55228 11.4477 9 12 9ZM13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12V16C11 16.5523 11.4477 17 12 17C12.5523 17 13 16.5523 13 16V12Z"
                        fill="currentColor"></path>
                </svg>
                <svg x-show="toast.type=='warning'" class="shrink-0 size-6 md:size-8 mr-1.5 -ml-1 text-orange-500"
                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.44829 4.46472C10.5836 2.51208 13.4105 2.51168 14.5464 4.46401L21.5988 16.5855C22.7423 18.5509 21.3145 21 19.05 21L4.94967 21C2.68547 21 1.25762 18.5516 2.4004 16.5862L9.44829 4.46472ZM11.9995 8C12.5518 8 12.9995 8.44772 12.9995 9V13C12.9995 13.5523 12.5518 14 11.9995 14C11.4473 14 10.9995 13.5523 10.9995 13V9C10.9995 8.44772 11.4473 8 11.9995 8ZM12.0009 15.99C11.4486 15.9892 11.0003 16.4363 10.9995 16.9886L10.9995 16.9986C10.9987 17.5509 11.4458 17.9992 11.9981 18C12.5504 18.0008 12.9987 17.5537 12.9995 17.0014L12.9995 16.9914C13.0003 16.4391 12.5532 15.9908 12.0009 15.99Z"
                        fill="currentColor"></path>
                </svg>
                <svg x-show="toast.type=='error'" class="shrink-0 size-6 md:size-8 mr-1.5 -ml-1 text-red-500"
                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9996 7C12.5519 7 12.9996 7.44772 12.9996 8V12C12.9996 12.5523 12.5519 13 11.9996 13C11.4474 13 10.9996 12.5523 10.9996 12V8C10.9996 7.44772 11.4474 7 11.9996 7ZM12.001 14.99C11.4488 14.9892 11.0004 15.4363 10.9997 15.9886L10.9996 15.9986C10.9989 16.5509 11.446 16.9992 11.9982 17C12.5505 17.0008 12.9989 16.5537 12.9996 16.0014L12.9996 15.9914C13.0004 15.4391 12.5533 14.9908 12.001 14.99Z"
                        fill="currentColor"></path>
                </svg>
                <p x-text="toast.message" class="select-none text-sm md:text-base text-gray-800 break-words"></p>
            </div>

            @if ($closeable)
                <button @click="toast.dispose()" type="button"
                    class="hidden opacity-40 hover:opacity-60 group-hover:block absolute right-0 p-2 focus:outline-none rtl:right-auto rtl:left-0 {{ $alignment->is('bottom') ? 'top-3' : 'top-0' }}">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            @endif
        </div>
    </template>
</div>
