@props(['size' => '7', 'color' => '#3b82f6'])
<div {{ $attributes->merge(['class' => '']) }}>
    <svg width="{{ $size }}" heigth="{{ $size }}" stroke="{{ $color }}" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <g class="spinner_V8m1">
            <circle cx="12" cy="12" r="9.5" fill="none" stroke-width="3"></circle>
        </g>
    </svg>
</div>
