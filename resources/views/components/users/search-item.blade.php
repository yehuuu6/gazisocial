@props(['user'])

<div class="flex flex-col">
    <x-link href="{{ route('user.show', $user->username) }}"
        class="flex gap-2 items-center p-2 hover:bg-gray-100 hover:no-underline"><img class="h-8 w-8 rounded-full"
            src="{{ $user->avatar }}" alt="avatar">
        <h3 class="text-sm font-medium text-blue-800">{{ $user->name }}</h3>
    </x-link>
</div>
