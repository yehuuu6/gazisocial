@props(['activity'])

<div class="flex flex-col user-activity p-4 gap-2">
    <div class="flex justify-between items-center">
        <div class="flex gap-2 items-center">
            <img class="size-8 rounded-full object-cover" src="{{ $activity->user->avatar }}" alt="avatar">
            <x-link href="/u/{{ $activity->user->username }}" class="font-medium">{{ $activity->user->name }}</x-link>
        </div>
        <span class="text-gray-500">{{ $activity->created_at->locale('tr')->shortAbsoluteDiffForHumans() }}</span>
    </div>
    <p class="text-gray-500">
        {{ $activity->content }}
        @if ($activity->link)
            <x-link class="text-blue-500 font-medium" href="{{ $activity->link }}">Göz at</x-link>
        @endif
    </p>
</div>
