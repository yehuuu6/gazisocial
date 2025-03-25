@if (!empty($images))
    <div x-data="{
        showGallery: false,
        currentIndex: 0,
        images: {{ json_encode($images) }},
        prev() {
            this.currentIndex = this.currentIndex > 0 ? this.currentIndex - 1 : this.images.length - 1;
        },
        next() {
            this.currentIndex = this.currentIndex < this.images.length - 1 ? this.currentIndex + 1 : 0;
        },
        keydownHandler(e) {
            if (this.showGallery) {
                if (e.key === 'ArrowLeft') this.prev();
                if (e.key === 'ArrowRight') this.next();
                if (e.key === 'Escape') this.showGallery = false;
            }
        }
    }" x-init="$watch('showGallery', value => {
        if (value) {
            document.body.style.overflow = 'hidden';
            window.addEventListener('keydown', keydownHandler);
        } else {
            document.body.style.overflow = '';
            window.removeEventListener('keydown', keydownHandler);
        }
    })" class="relative">
        <!-- Preview Image -->
        <div class="cursor-pointer" x-on:click="showGallery = true">
            <img src="{{ $images[0] }}" alt="Post image" class="w-full h-96 object-contain rounded-xl">
            @if (count($images) > 1)
                <div class="absolute bottom-4 right-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm">
                    +{{ count($images) - 1 }} görsel
                </div>
            @endif
        </div>

        <!-- Gallery Modal -->
        <div x-show="showGallery" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Close Button -->
            <button x-on:click="showGallery = false" class="absolute top-4 right-4 text-white hover:text-gray-300 z-50">
                <x-icons.close size="24" />
            </button>

            <!-- Image Counter -->
            <div class="absolute top-4 left-4 text-white text-sm">
                <span x-text="currentIndex + 1"></span>/<span x-text="images.length"></span>
            </div>

            <!-- Main Image -->
            <div class="relative w-full h-full flex items-center justify-center p-4">
                <img :src="images[currentIndex]" alt="Gallery image" class="max-h-[90vh] max-w-[90vw] object-contain">
            </div>

            <!-- Navigation Buttons -->
            <button x-show="images.length > 1" x-on:click="prev"
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-opacity">
                <x-icons.arrow-left-alt size="24" />
            </button>

            <button x-show="images.length > 1" x-on:click="next"
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-opacity">
                <x-icons.arrow-right-alt size="24" />
            </button>

            <!-- Thumbnails -->
            @if (count($images) > 1)
                <div
                    class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 px-4 py-2 bg-black bg-opacity-50 rounded-full">
                    <template x-for="(image, index) in images" :key="index">
                        <button x-on:click="currentIndex = index"
                            class="w-2 h-2 rounded-full transition-all duration-200"
                            :class="currentIndex === index ? 'bg-white scale-125' : 'bg-gray-400 hover:bg-gray-300'">
                        </button>
                    </template>
                </div>
            @endif
        </div>
    </div>
@endif
