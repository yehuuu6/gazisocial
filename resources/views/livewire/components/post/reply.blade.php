<div class="flex gap-3 border-l-2 border-gray-100 px-3.5 py-2">
    <img src="{{ asset($reply->user->avatar) }}" alt="avatar" class="size-8 object-cover rounded-full">
    <div class="w-full flex flex-col gap-2 justify-center">
        <div class="flex justify-between items-center">
            <div class="flex gap-1 md:items-center flex-col md:flex-row flex-wrap">
                <div class="flex items-center gap-1">
                    <x-link href="{{ route('users.show', $reply->user->username) }}" class="font-medium">
                        {{ $reply->user->name }}
                    </x-link>
                    <span class="text-sm text-gray-500">{{ '@' . $reply->user->username }}</span>
                </div>
                <span class="hidden md:inline-block text-gray-500 text-xs">•</span>
                <span class="text-sm text-gray-500">{{ $reply->created_at->locale('tr')->diffForHumans() }}
                    önce yanıtladı
                </span>
            </div>
            @auth
                @can('delete', $reply)
                    <button class="text-sm opacity-60 hover:opacity-100" title="Sil">
                        <x-icons.trash color="#ff6969" size="14" />
                    </button>
                @endcan
            @endauth
        </div>
        <p class="text-gray-600 break-all text-sm md:text-base">
            {{ $reply->content }}
        </p>
        <div class="flex gap-0 items-center">
            @auth
                <button wire:loading.remove class="hover:bg-blue-200 rounded-full p-2" wire:click="toggleLike()">
                    @if (!$this->isLikedByUser())
                        <x-icons.heart size='16' color="#4b5563" />
                    @else
                        <x-icons.heart-off size='16' color="#4b5563" />
                    @endif
                </button>
                <x-icons.spinner color='#4b5563' size='16' wire:loading.flex wire:target="toggleLike"
                    class="flex rounded-full p-2 items-center" />
            @endauth
            @guest
                <a class="hover:bg-blue-100 p-2 rounded-full" href="{{ route('login') }}">
                    <x-icons.heart size='16' color="#4b5563" />
                </a>
            @endguest
            <span class="text-gray-600 font-light">{{ $reply->likes_count }}</span>
        </div>
    </div>
</div>
