@php
    $state = $getState();
@endphp

@if ($state)
    <div class="rounded-lg overflow-hidden">
        <img src="{{ $state }}" alt="GIF" class="w-full max-h-96 object-cover max-w-full">
    </div>
@else
    <div class="text-gray-500">No GIF available</div>
@endif
