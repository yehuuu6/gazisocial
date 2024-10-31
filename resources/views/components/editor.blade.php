@props([
    'class' => '',
    'editorClass' => 'bg-gray-50',
    'content' => '',
])
<div x-data="{ content: @entangle($attributes->wire('model')), ...setupEditor('{{ preg_replace('/\s+/', ' ', $content) }}') }" x-init="() => init($refs.editor)" wire:ignore {{ $attributes->whereDoesntStartWith('wire:model') }}
    class="border border-gray-200 rounded-md {{ $class }}">
    <template x-if="isLoaded()">
        <menu class="bg-gray-100 flex flex-wrap divide-x border-b">
            <x-tooltip text="Kalın">
                <button x-on:click="toggleBold()" type="button"
                    :class="{
                        'bg-blue-500 text-white': isActive('bold', updatedAt),
                        'hover:bg-gray-200': !isActive('bold', updatedAt)
                    }"
                    class="px-4 py-3 flex item-center justify-center">
                    <x-icons.editor.bold size='18' />
                </button>
            </x-tooltip>
            <x-tooltip text="İtalik">
                <button x-on:click="toggleItalic()" type="button"
                    :class="{
                        'bg-blue-500 text-white': isActive('italic', updatedAt),
                        'hover:bg-gray-200': !isActive('italic', updatedAt)
                    }"
                    class="px-4 py-3 flex item-center justify-center">
                    <x-icons.editor.italic size='18' />
                </button>
            </x-tooltip>
            <x-tooltip text="Üstü Çizili">
                <button x-on:click="toggleStrike()" type="button"
                    :class="{
                        'bg-blue-500 text-white': isActive('strike', updatedAt),
                        'hover:bg-gray-200': !isActive('strike', updatedAt)
                    }"
                    class="px-4 py-3 flex item-center justify-center">
                    <x-icons.editor.strike size='18' />
                </button>
            </x-tooltip>
            <x-tooltip text="Alıntı">
                <button x-on:click="toggleQuote()" type="button"
                    :class="{
                        'bg-blue-500 text-white': isActive('blockquote', updatedAt),
                        'hover:bg-gray-200': !isActive('blockquote', updatedAt)
                    }"
                    class="px-4 py-3 flex item-center justify-center">
                    <x-icons.editor.quote size='18' />
                </button>
            </x-tooltip>
            <x-tooltip text="Madde İşaretli Liste">
                <button x-on:click="toggleBulletList()" type="button" title="Madde İşaretli Liste"
                    :class="{
                        'bg-blue-500 text-white': isActive('bulletList', updatedAt),
                        'hover:bg-gray-200': !isActive('bulletList', updatedAt)
                    }"
                    class="px-4 py-3 flex item-center justify-center">
                    <x-icons.editor.bullet-list size='18' />
                </button>
            </x-tooltip>
            <x-tooltip text="Numaralandırılmış Liste">
                <button x-on:click="toggleOrderedList()" type="button"
                    :class="{
                        'bg-blue-500 text-white': isActive('orderedList', updatedAt),
                        'hover:bg-gray-200': !isActive('orderedList', updatedAt)
                    }"
                    class="px-4 py-3 flex item-center justify-center">
                    <x-icons.editor.ordered-list size='18' />
                </button>
            </x-tooltip>
            <x-tooltip text="Bağlantı Ekle">
                <button x-on:click="promptUserForHref()" type="button" title="Bağlantı Ekle"
                    :class="{
                        'bg-blue-500 text-white': isActive('link', updatedAt),
                        'hover:bg-gray-200': !isActive('link', updatedAt)
                    }"
                    class="px-4 py-3 flex item-center justify-center">
                    <x-icons.editor.link size='18' />
                </button>
            </x-tooltip>
            <x-tooltip text="Başlık 1">
                <button x-on:click="toggleHeading({ level: 3 })" type="button"
                    :class="{
                        'bg-blue-500 text-white': isActive('heading', { level: 3 }, updatedAt),
                        'hover:bg-gray-200': !isActive('heading', { level: 3 }, updatedAt)
                    }"
                    class="px-4 py-3 flex item-center justify-center">
                    <x-icons.editor.heading-1 size='18' />
                </button>
            </x-tooltip>
            <x-tooltip text="Başlık 2">
                <button x-on:click="toggleHeading({ level: 4 })" type="button"
                    :class="{
                        'bg-blue-500 text-white': isActive('heading', { level: 4 }, updatedAt),
                        'hover:bg-gray-200': !isActive('heading', { level: 4 }, updatedAt)
                    }"
                    class="px-4 py-3 flex item-center justify-center">
                    <x-icons.editor.heading-2 size='18' />
                </button>
            </x-tooltip>
            <x-tooltip text="Başlık 3">
                <button x-on:click="toggleHeading({ level: 5 })" type="button"
                    :class="{
                        'bg-blue-500 text-white': isActive('heading', { level: 5 }, updatedAt),
                        'hover:bg-gray-200': !isActive('heading', { level: 5 }, updatedAt)
                    }"
                    class="px-4 py-3 flex item-center justify-center">
                    <x-icons.editor.heading-3 size='18' />
                </button>
            </x-tooltip>
        </menu>
    </template>
    <div class="{{ $editorClass }}" x-ref="editor">

    </div>
</div>
