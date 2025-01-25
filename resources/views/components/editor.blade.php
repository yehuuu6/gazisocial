<div {{ $attributes }} wire:ignore x-data="{
    content: $wire.entangle('content'),
}">
    <div x-data="editor(content)" class="border border-gray-200 rounded-md">
        <template x-if="isLoaded()">
            <menu class="bg-gray-100 text-gray-600 flex flex-wrap divide-x border-b">
                <x-ui.tooltip text="Başlık 1">
                    <button x-on:click="toggleHeading({ level: 2 })" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('heading', { level: 2 }, updatedAt),
                            'hover:bg-gray-200': !isActive('heading', { level: 2 }, updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.heading-1 size="24" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip text="Başlık 2">
                    <button x-on:click="toggleHeading({ level: 3 })" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('heading', { level: 3 }, updatedAt),
                            'hover:bg-gray-200': !isActive('heading', { level: 3 }, updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.heading-2 size="24" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip text="Başlık 3">
                    <button x-on:click="toggleHeading({ level: 4 })" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('heading', { level: 4 }, updatedAt),
                            'hover:bg-gray-200': !isActive('heading', { level: 4 }, updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.heading-3 size="24" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip text="Kalın">
                    <button x-on:click="toggleBold()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('bold', updatedAt),
                            'hover:bg-gray-200': !isActive('bold', updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.bold size="24" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip text="İtalik">
                    <button x-on:click="toggleItalic()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('italic', updatedAt),
                            'hover:bg-gray-200': !isActive('italic', updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.italic size="24" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip text="Altı Çizili">
                    <button x-on:click="toggleUnderline()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('underline', updatedAt),
                            'hover:bg-gray-200': !isActive('underline', updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.underline size="24" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip text="Üstü Çizili">
                    <button x-on:click="toggleStrike()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('strike', updatedAt),
                            'hover:bg-gray-200': !isActive('strike', updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.strike size="24" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip text="Alıntı">
                    <button x-on:click="toggleQuote()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('blockquote', updatedAt),
                            'hover:bg-gray-200': !isActive('blockquote', updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.quote size="24" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip text="Madde İşaretli Liste">
                    <button x-on:click="toggleBulletList()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('bulletList', updatedAt),
                            'hover:bg-gray-200': !isActive('bulletList', updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.bullet-list size="24" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip text="Numaralandırılmış Liste">
                    <button x-on:click="toggleOrderedList()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('orderedList', updatedAt),
                            'hover:bg-gray-200': !isActive('orderedList', updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.ordered-list size="24" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip text="Bağlantı Ekle">
                    <button x-on:click="promptUserForHref()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('link', updatedAt),
                            'hover:bg-gray-200': !isActive('link', updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.link size="24" />
                    </button>
                </x-ui.tooltip>
                <x-ui.tooltip text="Kod Bloğu Ekle">
                    <button x-on:click="toggleCodeBlock()" type="button"
                        :class="{
                            'bg-blue-500 text-white': isActive('codeBlock', updatedAt),
                            'hover:bg-gray-200': !isActive('codeBlock', updatedAt)
                        }"
                        class="px-4 py-3 flex item-center justify-center">
                        <x-icons.code size="24" />
                    </button>
                </x-ui.tooltip>
            </menu>
        </template>

        <div x-ref="element"></div>
    </div>

</div>
