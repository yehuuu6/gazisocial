<div>
    <button
        {{ $attributes->merge(['class' => 'flex items-center justify-center gap-1 text-xs md:text-sm font-medium text-gray-800 px-1.5 md:px-3 py-1 rounded-full hover:bg-gray-100']) }}>
        {{ $slot }}
    </button>
</div>
