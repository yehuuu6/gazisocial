<div {{ $attributes }} x-show="{{ $attributes->wire('modal')->value }}" x-cloak
    x-on:keydown.escape.window="{{ $attributes->wire('modal')->value }} = false">
    <div class="fixed inset-0 bg-gray-700 bg-opacity-85 z-30" x-show="{{ $attributes->wire('modal')->value }}"
        x-transition.opacity></div>
    <div x-on:click.outside="{{ $attributes->wire('modal')->value }} = false"
        x-show="{{ $attributes->wire('modal')->value }}" x-transition
        class="bg-white h-min shadow-md max-w-md m-auto lg:max-w-lg rounded-md fixed z-50 inset-0">
        <div class="flex flex-col h-full justify-between">
            <header class="bg-slate-50 rounded-t-md">
                {{ $title }}
            </header>
            <x-seperator />
            <main>
                {{ $body }}
            </main>
            <x-seperator />
            <footer class="bg-slate-100 rounded-b-md overflow-hidden">
                {{ $footer }}
            </footer>
        </div>
    </div>
</div>
