@props(['title', 'avatar'])

@php

    $slug = Str::slug($title);
@endphp

<div class="flex flex-col">
    <x-link href="/posts/{{ $slug }}"
        class="flex gap-2 items-center p-5 hover:bg-gray-100 hover:no-underline"><img class="h-8 w-8 rounded-full"
            src="{{ $avatar }}" alt="avatar">
        <h3 class="text-sm font-medium text-blue-800">{{ $title }}</h3>
    </x-link>
</div>
