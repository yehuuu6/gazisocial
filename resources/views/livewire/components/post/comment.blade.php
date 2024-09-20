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
                <p class="text-sm text-gray-500">{{ $comment->created_at->locale('tr')->diffForHumans() }}</p>
            </div>
            @auth
                @can('delete', $comment)
                    <button wire:click="deleteComment" class="text-sm opacity-60 hover:opacity-100" title="Sil">
                        <x-icons.trash color="#ff6969" size="14" />
                    </button>
                @endcan
            @endauth
        </div>
        <p class="text-gray-600 break-all">
            {{ $comment->content }}
        </p>
        <div class="post-icon flex gap-1">
            <div class="flex gap-0 items-center">
                <button class="hover:bg-blue-200 rounded-full p-2">
                    <x-icons.comment color="#4b5563" />
                </button>
                <p class="text-gray-600 font-light">{{ $comment->comments_count }}</p>
            </div>
            <div class="flex gap-0 items-center">
                @auth
                    <button wire:loading.remove class="hover:bg-blue-200 rounded-full p-2" wire:click="toggleLike()">
                        @if (!$this->isLikedByUser())
                            <x-icons.heart color="#4b5563" />
                        @else
                            <x-icons.heart-off color="#4b5563" />
                        @endif
                    </button>
                    <x-icons.spinner color='#4b5563' size='6' wire:loading.flex wire:target="toggleLike"
                        class="flex rounded-full p-2 items-center" />
                @endauth
                @guest
                    <a class="hover:bg-blue-100 p-2 rounded-full" href="{{ route('login') }}">
                        <x-icons.heart color="#4b5563" />
                    </a>
                @endguest
                <p class="text-gray-600 font-light">{{ $comment->likes_count }}</p>
            </div>
        </div>
    </div>
</li>
