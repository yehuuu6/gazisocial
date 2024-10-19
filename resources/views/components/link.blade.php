<a wire:navigate.hover {{ $attributes->merge(['class' => 'hover:underline']) }}>
    {{ $slot }}
</a>
