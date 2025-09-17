@props(['post'])

<div class="flex flex-col">
    <x-link href="{{ $post->showRoute() }}" class="flex gap-2 items-center p-5 hover:bg-gray-100 hover:no-underline">
        @if ($post->isAnonim())
            <div class="h-8 w-8 rounded-full bg-gray-300 grid place-items-center">
                <x-tabler-user class="size-4 text-gray-500" />
            </div>
        @else
            <img class="h-8 w-8 rounded-full" src="{{ $post->user->getAvatar() }}" alt="avatar">
        @endif
        <h3 class="text-sm font-medium text-blue-800">{{ $post->title }}</h3>
    </x-link>
</div>
