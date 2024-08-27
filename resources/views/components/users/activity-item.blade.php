@props(['name', 'time', 'content'])

@php
    $slug = Str::slug($name);
@endphp

<div class="flex flex-col user-activity p-4">
    <div class="flex justify-between items-center">
        <div class="flex gap-2 items-center">
            <img class="h-8 w-8 rounded-full" src="https://generated.vusercontent.net/placeholder-user.jpg" alt="avatar">
            <a href="/u/{{ $slug }}" class="font-medium">{{ $name }}</a>
        </div>
        <span class="text-gray-500">{{ $time }}</span>
    </div>
    <p class="ml-2 text-gray-500">{{ $content }}</p>
</div>
