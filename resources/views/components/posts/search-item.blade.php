@props(['post'])

<div class="flex flex-col">
    <x-link href="{{ $post->showRoute() }}" class="flex gap-2 items-center p-5 hover:bg-gray-100 hover:no-underline"><img
            class="h-8 w-8 rounded-full" src="{{ $post->user->avatar }}" alt="avatar">
        <h3 class="text-sm font-medium text-blue-800">{{ $post->title }}</h3>
    </x-link>
</div>
