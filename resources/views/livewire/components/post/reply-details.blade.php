<div x-data="{ addReplyModal: false }" class="flex gap-2 p-3 sm:gap-4 sm:p-5">
    @auth
        <livewire:modals.create-reply-modal />
    @endauth
    <img class="size-12 md:size-14 rounded-full object-cover" src="{{ asset($comment->user->avatar) }}" alt="avatar">
    <div class="flex w-full flex-col gap-2 sm:gap-4">
        <div class="flex items-center justify-between">
            <div class="flex flex-col-reverse items-baseline gap-1 sm:flex-row">
                <div class="flex flex-col gap-1 sm:flex-row">
                    <x-link href="/u/{{ $comment->user->username }}" class="font-medium">
                        {{ $comment->user->name }}
                    </x-link>
                    <div class="flex flex-col gap-1 md:flex-row md:items-center">
                        <span class="text-sm text-gray-500">{{ '@' . $comment->user->username }}</span>
                        <span class="hidden text-xs text-gray-500 md:inline-block">•</span>
                        <span class="text-sm text-gray-500">
                            {{ $comment->created_at->locale('tr')->diffForHumans() }} <x-link
                                href="{{ $post->showRoute() }}" class="text-blue-500">{{ $post->title }}</x-link>
                            adlı gönderiye yorum yaptı
                        </span>
                    </div>
                </div>
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
        <article class="prose prose-sm max-w-none break-all sm:prose-base lg:prose-lg"
            wire:loading.class="animate-pulse" wire:target.except='toggleLike'>
            {{ $comment->content }}
        </article>
        <div class="flex gap-1">
            <div class="flex items-center gap-0">
                @auth
                    <button class="rounded-full p-2 hover:bg-blue-200" @click="addReplyModal = true">
                        <x-icons.reply size="14" color="#4b5563" />
                    </button>
                @endauth
                @guest
                    <a class="rounded-full p-2 hover:bg-blue-100" href="{{ route('login') }}">
                        <x-icons.reply size="14" color="#4b5563" />
                    </a>
                @endguest
                <span class="font-light text-gray-600">{{ Number::abbreviate($comment->replies_count) }}</span>
            </div>
            <div class="flex items-center gap-0">
                @auth
                    <button wire:loading.remove class="rounded-full p-2 hover:bg-blue-200" wire:click="toggleLike()">
                        @if (!$this->isLikedByUser())
                            <x-icons.heart size="14" />
                        @else
                            <x-icons.heart-off size="14" />
                        @endif
                    </button>
                    <x-icons.spinner color='#4b5563' size='6' wire:loading.flex wire:target="toggleLike"
                        class="flex items-center rounded-full p-2" />
                @endauth
                @guest
                    <a class="rounded-full p-2 hover:bg-blue-100" href="{{ route('login') }}">
                        <x-icons.heart size="14" />
                    </a>
                @endguest
                <span class="font-light text-gray-600">{{ Number::abbreviate($comment->likes_count) }}</span>
            </div>
        </div>
    </div>
</div>
