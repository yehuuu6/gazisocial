@props(['id' => ''])
@php
    $id = $id === '' ? '' : 'id=' . $id . '';
@endphp
<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div {{ $id }} class="absolute overflow-y-auto overflow-x-hidden h-full w-full">
        {{ $slot }}
    </div>
</div>
