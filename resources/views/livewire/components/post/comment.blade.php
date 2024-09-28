<li>
    <div class="flex gap-3 px-5 py-1">
        <img src="{{ asset($comment->user->avatar) }}" alt="avatar" class="size-8 object-cover rounded-full">
        <div class="w-full flex flex-col gap-2 justify-center">
            <div class="flex justify-between items-center">
                <div class="flex gap-1 md:items-center flex-col md:flex-row flex-wrap">
                    <div class="flex items-center gap-1">
                        <x-link href="/u/{{ $comment->user->username }}" class="font-medium">
                            {{ $comment->user->name }}
                        </x-link>
                        @if ($postAuthor == $comment->user->id)
                            <span
                                class="ml-1 py-1 px-2 bg-primary text-white font-medium rounded-full capitalize text-xs">
                                Konu Sahibi
                            </span>
                        @else
                            <span class="text-sm text-gray-500">{{ '@' . $comment->user->username }}</span>
                        @endif
                    </div>
                    <span class="hidden md:inline-block text-gray-500 text-xs">•</span>
                    <span class="text-sm text-gray-500">{{ $comment->created_at->locale('tr')->diffForHumans() }}</span>
                </div>
                @auth
                    @can('delete', $comment)
                        <button
                            @click="commentId = {{ $comment->id }}; deleteCommentModal = true; $dispatch('delete-comment-modal-open')"
                            class="text-sm opacity-60 hover:opacity-100" title="Sil">
                            <x-icons.trash color="#ff6969" size="14" />
                        </button>
                    @endcan
                @endauth
            </div>
            <p class="text-gray-600 break-all text-sm md:text-base">
                {{ $comment->content }}
            </p>
            <div class="post-icon flex gap-1">
                <div class="flex gap-0 items-center">
                    <button class="hover:bg-blue-200 rounded-full p-2">
                        <x-icons.comment color="#4b5563" />
                    </button>
                    <span class="text-gray-600 font-light">{{ $comment->replies_count }}</span>
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
                    <span class="text-gray-600 font-light">{{ $comment->likes_count }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="ml-10 px-3.5 py-1">
        @foreach ($comment->replies as $reply)
            <livewire:components.post.reply :$reply :key="'reply-' . $reply->id" />
        @endforeach
        @if ($comment->replies_count > 5)
            <div class="flex ml-3.5 my-3">
                <x-link href="{{ $comment->post->showRoute() }}"
                    class="text-gray-500 text-sm font-medium hover:underline">
                    Tüm konuşmayı gör
                </x-link>
            </div>
        @endif
    </div>
</li>
