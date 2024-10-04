@props(['class' => '', 'editorClass' => 'bg-gray-50'])
<div x-data="{ content: @entangle($attributes->wire('model')), ...setupEditor() }" x-init="() => init($refs.editor)" wire:ignore {{ $attributes->whereDoesntStartWith('wire:model') }}
    class="border border-gray-200 rounded-md {{ $class }}">
    <template x-if="isLoaded()">
        <menu class="bg-gray-100 flex flex-wrap divide-x border-b">
            <button x-on:click="toggleBold()" type="button" title="Kalın"
                :class="{
                    'bg-blue-500 text-white': isActive('bold', updatedAt),
                    'hover:bg-gray-200': !isActive('bold', updatedAt)
                }"
                class="px-4 py-3 flex item-center justify-center">
                <x-icons.editor.bold size='18' />
            </button>
            <button x-on:click="toggleItalic()" type="button" title="İtalik"
                :class="{
                    'bg-blue-500 text-white': isActive('italic', updatedAt),
                    'hover:bg-gray-200': !isActive('italic', updatedAt)
                }"
                class="px-4 py-3 flex item-center justify-center">
                <x-icons.editor.italic size='18' />
            </button>
            <button x-on:click="toggleStrike()" type="button" title="Üstü Çizili"
                :class="{
                    'bg-blue-500 text-white': isActive('strike', updatedAt),
                    'hover:bg-gray-200': !isActive('strike', updatedAt)
                }"
                class="px-4 py-3 flex item-center justify-center">
                <x-icons.editor.strike size='18' />
            </button>
            <button x-on:click="toggleQuote()" type="button" title="Alıntı"
                :class="{
                    'bg-blue-500 text-white': isActive('blockquote', updatedAt),
                    'hover:bg-gray-200': !isActive('blockquote', updatedAt)
                }"
                class="px-4 py-3 flex item-center justify-center">
                <x-icons.editor.quote size='18' />
            </button>
            <button x-on:click="toggleBulletList()" type="button" title="Madde İşaretli Liste"
                :class="{
                    'bg-blue-500 text-white': isActive('bulletList', updatedAt),
                    'hover:bg-gray-200': !isActive('bulletList', updatedAt)
                }"
                class="px-4 py-3 flex item-center justify-center">
                <x-icons.editor.bullet-list size='18' />
            </button>
            <button x-on:click="toggleOrderedList()" type="button" title="Numaralandırılmış Liste"
                :class="{
                    'bg-blue-500 text-white': isActive('orderedList', updatedAt),
                    'hover:bg-gray-200': !isActive('orderedList', updatedAt)
                }"
                class="px-4 py-3 flex item-center justify-center">
                <x-icons.editor.ordered-list size='18' />
            </button>
            <button x-on:click="promptUserForHref()" type="button" title="Bağlantı Ekle"
                :class="{
                    'bg-blue-500 text-white': isActive('link', updatedAt),
                    'hover:bg-gray-200': !isActive('link', updatedAt)
                }"
                class="px-4 py-3 flex item-center justify-center">
                <x-icons.editor.link size='18' />
            </button>
            <button x-on:click="toggleHeading({ level: 3 })" type="button" title="Başlık 1"
                :class="{
                    'bg-blue-500 text-white': isActive('heading', { level: 3 }, updatedAt),
                    'hover:bg-gray-200': !isActive('heading', { level: 3 }, updatedAt)
                }"
                class="px-4 py-3 flex item-center justify-center">
                <x-icons.editor.heading-1 size='18' />
            </button>
            <button x-on:click="toggleHeading({ level: 4 })" type="button" title="Başlık 2"
                :class="{
                    'bg-blue-500 text-white': isActive('heading', { level: 4 }, updatedAt),
                    'hover:bg-gray-200': !isActive('heading', { level: 4 }, updatedAt)
                }"
                class="px-4 py-3 flex item-center justify-center">
                <x-icons.editor.heading-2 size='18' />
            </button>
            <button x-on:click="toggleHeading({ level: 5 })" type="button" title="Başlık 3"
                :class="{
                    'bg-blue-500 text-white': isActive('heading', { level: 5 }, updatedAt),
                    'hover:bg-gray-200': !isActive('heading', { level: 5 }, updatedAt)
                }"
                class="px-4 py-3 flex item-center justify-center">
                <x-icons.editor.heading-3 size='18' />
            </button>
        </menu>
    </template>
    <div class="{{ $editorClass }}" x-ref="editor">

    </div>
</div>
