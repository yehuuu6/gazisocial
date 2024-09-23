<div x-cloak x-transition
    {{ $attributes->merge([
        'class' => 'rounded-lg w-full md:w-3/4 lg:w-1/2 overflow-hidden bg-gray-50 mx-5 md:mx-0 md:mb-0 mb-5',
    ]) }}>
    {{ $slot }}
</div>
