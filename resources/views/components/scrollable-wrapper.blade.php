@props(['id' => '', 'scrollTheme' => 'light'])
@php
    $id = $id === '' ? '' : 'id=' . $id . '';

    $scrollTheme = $scrollTheme === 'dark' ? 'scrollbar-track-primary scrollbar-thumb-blue-500' : '';
@endphp
<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div {{ $id }} class="absolute overflow-y-auto overflow-x-hidden h-full w-full {{ $scrollTheme }}">
        {{ $slot }}
    </div>
</div>
