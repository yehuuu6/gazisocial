<div {{ $attributes }} wire:ignore x-data="{
    content: $wire.entangle('content'),
}">
    <div x-data="editor(content)" class="rounded-md">
        <template x-if="isLoaded()">
            <menu x-data="{ navbarHeight: 0 }" x-init="navbarHeight = document.getElementById('navbar').offsetHeight;
            const formHeader = document.querySelector('#formHeader');
            const formHeaderHeight = formHeader.offsetHeight;
            $el.style.top = (navbarHeight + formHeaderHeight) + 'px';"
                class ="bg-white border border-gray-200 text-gray-800 flex
                flex-wrap divide-x rounded-t-md sticky z-[1]">
                <x-ui.tooltip position="bottom" text="Başlık 1">
                    <button x-on:click="toggleHeading({ level: 2 })" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('heading', { level: 2 }, updatedAt),
                            'hover:bg-gray-200': !isActive('heading', { level: 2 }, updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-h-1 class="size-5" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip position="bottom" text="Başlık 2">
                    <button x-on:click="toggleHeading({ level: 3 })" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('heading', { level: 3 }, updatedAt),
                            'hover:bg-gray-200': !isActive('heading', { level: 3 }, updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-h-2 class="size-5" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip position="bottom" text="Başlık 3">
                    <button x-on:click="toggleHeading({ level: 4 })" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('heading', { level: 4 }, updatedAt),
                            'hover:bg-gray-200': !isActive('heading', { level: 4 }, updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-h-3 class="size-5" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip position="bottom" text="Kalın">
                    <button x-on:click="toggleBold()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('bold', updatedAt),
                            'hover:bg-gray-200': !isActive('bold', updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-bold class="size-5" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip position="bottom" text="İtalik">
                    <button x-on:click="toggleItalic()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('italic', updatedAt),
                            'hover:bg-gray-200': !isActive('italic', updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-italic class="size-5" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip position="bottom" text="Altı Çizili">
                    <button x-on:click="toggleUnderline()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('underline', updatedAt),
                            'hover:bg-gray-200': !isActive('underline', updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-underline class="size-5" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip position="bottom" text="Üstü Çizili">
                    <button x-on:click="toggleStrike()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('strike', updatedAt),
                            'hover:bg-gray-200': !isActive('strike', updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-strikethrough class="size-5" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip position="bottom" text="Alıntı">
                    <button x-on:click="toggleQuote()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('blockquote', updatedAt),
                            'hover:bg-gray-200': !isActive('blockquote', updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-quote class="size-5" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip position="bottom" text="Madde İşaretli Liste">
                    <button x-on:click="toggleBulletList()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('bulletList', updatedAt),
                            'hover:bg-gray-200': !isActive('bulletList', updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-list class="size-5" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip position="bottom" text="Numaralandırılmış Liste">
                    <button x-on:click="toggleOrderedList()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('orderedList', updatedAt),
                            'hover:bg-gray-200': !isActive('orderedList', updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-list-numbers class="size-5" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip position="bottom" text="Bağlantı Ekle">
                    <button x-on:click="promptUserForHref()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('link', updatedAt),
                            'hover:bg-gray-200': !isActive('link', updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-link class="size-5" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip position="bottom" text="Kod Bloğu Ekle">
                    <button x-on:click="toggleCodeBlock()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('codeBlock', updatedAt),
                            'hover:bg-gray-200': !isActive('codeBlock', updatedAt)
                        }"
                        class="p-3 flex item-center justify-center">
                        <x-tabler-code class="size-5" />
                    </button>
                </x-ui.tooltip>
            </menu>
        </template>

        <div x-ref="element" class="mt-0.5"></div>
    </div>

</div>
