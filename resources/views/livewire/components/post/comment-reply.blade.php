<li class="flex gap-3 @if ($type == 'nested') border-l-2 border-gray-100 @endif px-3.5 py-2">
    <img src="{{ asset($reply->user->avatar) }}" alt="avatar" class="size-8 rounded-full object-cover">
    <div class="flex w-full flex-col justify-center gap-2">
        <div class="flex items-center justify-between">
            <div class="flex flex-col flex-wrap gap-1 md:flex-row md:items-center">
                <div class="flex items-center gap-1">
                    <x-link href="{{ route('users.show', $reply->user->username) }}" class="font-medium">
                        {{ $reply->user->name }}
                    </x-link>
                    @if ($reply->post->user->id == $reply->user->id && !$reply->post->is_anon)
                        <span class="ml-1 rounded-full bg-primary px-2 py-1 text-xs font-medium capitalize text-white">
                            Konu Sahibi
                        </span>
                    @else
                        <span class="text-sm text-gray-500">{{ '@' . $reply->user->username }}</span>
                    @endif
                </div>
                <span class="hidden text-xs text-gray-500 md:inline-block">•</span>
                <span class="text-sm text-gray-500">{{ $reply->created_at->locale('tr')->diffForHumans() }}
                    önce yanıtladı
                </span>
                @if ($isNew)
                    <x-tooltip text="Yanıtınız yeni eklenmiştir. Daha sonra silebilirsiniz."
                        class="text-xs px-2 py-1 bg-emerald-400 text-white rounded-full">Yeni</x-tooltip>
                @endif
            </div>
            @auth
                @can('delete', $reply)
                    @if (!$isNew)
                        <button
                            @click="replyId = {{ $reply->id }}; deleteReplyModal = true; $dispatch('delete-reply-modal-open')"
                            class="text-sm opacity-60 hover:opacity-100" title="Sil">
                            <x-icons.trash color="#ff6969" size="14" />
                        </button>
                    @endif
                @endcan
            @endauth
        </div>
        <p class="break-all text-sm text-gray-600 md:text-base">
            {{ $reply->content }}
        </p>
        <div class="flex gap-1">
            <div class="flex items-center gap-0">
                @auth
                    <button wire:loading.remove class="rounded-full p-2 hover:bg-blue-200" wire:click="toggleLike()">
                        @if (!$this->isLikedByUser())
                            <x-icons.heart size='16' color="#4b5563" />
                        @else
                            <x-icons.heart-off size='16' color="#4b5563" />
                        @endif
                    </button>
                    <x-icons.spinner color='#4b5563' size='16' wire:loading.flex wire:target="toggleLike"
                        class="flex items-center rounded-full p-2" />
                @endauth
                @guest
                    <a class="rounded-full p-2 hover:bg-blue-100" href="{{ route('login') }}">
                        <x-icons.heart size='16' color="#4b5563" />
                    </a>
                @endguest
                <span class="font-light text-gray-600">{{ $reply->likes_count }}</span>
            </div>
        </div>
    </div>
</li>
