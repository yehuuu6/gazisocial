<li class="flex gap-3 px-5 py-1">
    <img src="{{ asset($comment->user->avatar) }}" alt="avatar" class="size-8 object-cover rounded-full">
    <div class="w-full flex flex-col gap-2 justify-center">
        <div class="flex justify-between items-center">
            <div class="flex gap-1 items-center">
                <x-link href="/u/{{ $comment->user->username }}" class="font-medium">
                    {{ $comment->user->name }}
                </x-link>
                @if ($postAuthor == $comment->user->id)
                    <span class="ml-1 py-1 px-2 bg-primary text-white font-medium rounded-full capitalize text-xs">
                        Konu Sahibi
                    </span>
                @else
                    <p class="text-sm text-gray-500">{{ '@' . $comment->user->username }}</p>
                @endif
                <span class="inline-block text-gray-500 text-xs">•</span>
                <p class="text-sm text-gray-500">{{ $comment->created_at->shortAbsoluteDiffForHumans() }}</p>
            </div>
            @auth
                @can('delete', $comment)
                    <button wire:click="deleteComment" class="text-sm opacity-60 hover:opacity-100" title="Sil">
                        <x-icons.trash color="#ff6969" size="14" />
                    </button>
                @endcan
            @endauth
        </div>
        <p class="text-gray-600 break-all">{{ $comment->content }}</p>
        <div class="post-icon flex">
            <x-icons.comment />
            <x-icons.heart />
        </div>
    </div>
</li>
