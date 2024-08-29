<li class="flex gap-3 px-5 py-1">
    <img src="{{ asset($comment->user->avatar) }}" alt="avatar" class="w-8 h-8 rounded-full">
    <div class="w-full flex flex-col gap-2 justify-center">
        <div class="flex justify-between items-center">
            <div class="flex gap-1 items-center">
                <x-link href="/u/{{ $comment->user->username }}" class="font-medium">
                    {{ $comment->user->name }}
                </x-link>
                <p class="text-sm text-gray-500">{{ $username }}</p>
            </div>
            <p class="text-sm text-gray-500">
                {{ $time }}</p>
        </div>
        <p class="text-gray-600 break-words">{{ $comment->content }}</p>
        <div class="post-icon flex">
            <x-icons.comment />
            <x-icons.heart />
        </div>
    </div>
</li>
