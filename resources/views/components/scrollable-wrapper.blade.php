<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="absolute overflow-y-auto overflow-x-hidden h-full w-full">
        {{ $slot }}
    </div>
</div>
