<div x-cloak x-transition.opacity.duration.250ms role="dialog" aria-modal="true"
    {{ $attributes->merge([
        'class' => 'fixed inset-0 bg-gray-500 bg-opacity-50 flex md:items-center items-end
            justify-center h-full z-50',
    ]) }}>
    {{ $slot }}
</div>
