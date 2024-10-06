<li>
    <div class="flex gap-3 px-5 py-1">
        <img src="{{ asset($comment->user->avatar) }}" alt="avatar" class="size-8 rounded-full object-cover">
        <div class="flex w-full flex-col justify-center gap-2">
            <div class="flex items-center justify-between">
                <div class="flex flex-col flex-wrap gap-1 md:flex-row md:items-center">
                    <div class="flex items-center gap-1">
                        <x-link href="/u/{{ $comment->user->username }}" class="font-medium">
                            {{ $comment->user->name }}
                        </x-link>
                        @if ($postAuthor == $comment->user->id)
                            <span
                                class="ml-1 rounded-full bg-primary px-2 py-1 text-xs font-medium capitalize text-white">
                                Konu Sahibi
                            </span>
                        @else
                            <span class="text-sm text-gray-500">{{ '@' . $comment->user->username }}</span>
                        @endif
                    </div>
                    <span class="hidden text-xs text-gray-500 md:inline-block">•</span>
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
            <p class="break-all text-sm text-gray-600 md:text-base">
                {{ $comment->content }}
            </p>
            <div class="post-icon flex gap-1">
                <div class="flex items-center gap-0">
                    @auth
                        <button
                            @click="commentId = {{ $comment->id }}; addReplyModal = true; $dispatch('add-reply-modal-open')"
                            class="rounded-full p-2 hover:bg-blue-200">
                            <x-icons.reply color="#4b5563" />
                        </button>
                    @endauth
                    @guest
                        <x-link href="{{ route('login') }}" class="rounded-full p-2 hover:bg-blue-100">
                            <x-icons.reply color="#4b5563" />
                        </x-link>
                    @endguest
                    <span class="font-light text-gray-600">{{ $comment->replies_count }}</span>
                </div>
                <div class="flex items-center gap-0">
                    @auth
                        <button wire:loading.remove class="rounded-full p-2 hover:bg-blue-200" wire:click="toggleLike()">
                            @if (!$this->isLikedByUser())
                                <x-icons.heart color="#4b5563" />
                            @else
                                <x-icons.heart-off color="#4b5563" />
                            @endif
                        </button>
                        <x-icons.spinner color='#4b5563' size='6' wire:loading.flex wire:target="toggleLike"
                            class="flex items-center rounded-full p-2" />
                    @endauth
                    @guest
                        <a class="rounded-full p-2 hover:bg-blue-100" href="{{ route('login') }}">
                            <x-icons.heart color="#4b5563" />
                        </a>
                    @endguest
                    <span class="font-light text-gray-600">{{ $comment->likes_count }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="ml-10 px-3.5 py-1">
        <ul>
            @foreach ($replies as $reply)
                <livewire:components.post.comment-reply :$postAuthor :$reply :key="'reply-' . $reply->id" />
            @endforeach
        </ul>
        @if ($comment->replies_count > 5)
            <div class="my-3 ml-3.5 flex">
                <x-link href="{{ route('posts.replies', ['post' => $comment->post->id, 'comment' => $comment->id]) }}"
                    class="text-sm font-medium text-gray-500 hover:underline">
                    Tüm konuşmayı gör
                </x-link>
            </div>
        @endif
    </div>
</li>
