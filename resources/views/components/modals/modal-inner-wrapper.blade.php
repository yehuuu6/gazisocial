<div x-cloak x-transition
    {{ $attributes->merge([
        'class' => 'rounded-lg w-full max-w-2xl overflow-hidden bg-gray-50 mx-5 md:mx-0 md:mb-0 mb-5',
    ]) }}>
    {{ $slot }}
</div>
