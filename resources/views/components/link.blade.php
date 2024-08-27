<a wire:navigate {{ $attributes->merge(['class' => 'hover:underline']) }}>
    {{ $slot }}
</a>
