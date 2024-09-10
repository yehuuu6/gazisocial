<div class="flex flex-col p-2 md:p-4">
    <div class="flex justify-between items-center">
        <div class="flex gap-1 items-center">
            <img class="size-7 mr-2 md:size-8 rounded-full" src="{{ $user->avatar }}" alt="avatar">
            <x-link title="{{ $user->name }}" href="/u/{{ $user->username }}"
                class="text-base md:text-lg font-medium text-blue-800">
                {{ $user->name }}
            </x-link>
            <span class="text-gray-500 text-xs md:text-sm">{{ '@' . $user->username }}</span>
        </div>
    </div>
    <p class="ml-2 mt-2 text-gray-500 break-all text-sm md:text-base line-clamp-1">{{ $bio }}</p>
</div>
