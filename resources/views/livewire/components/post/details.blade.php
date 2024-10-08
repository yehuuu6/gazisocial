<div x-data="{ addCommentModal: false }" class="flex gap-2 p-3 sm:gap-4 sm:p-5">
    @auth
        <livewire:modals.create-comment-modal :$post />
    @endauth
    <img class="size-12 md:size-14 rounded-full object-cover" src="{{ asset($post->user->avatar) }}" alt="avatar">
    <div class="flex w-full flex-col gap-2 sm:gap-4">
        <div class="flex items-center justify-between">
            <div class="flex flex-col-reverse items-baseline gap-1 sm:flex-row">
                <div class="flex flex-col gap-1 sm:flex-row">
                    <x-link href="/u/{{ $post->user->username }}" class="font-medium">
                        {{ $post->user->name }}
                    </x-link>
                    <div class="flex items-center gap-1">
                        <span class="text-sm text-gray-500">{{ '@' . $post->user->username }}</span>
                        <span class="inline-block text-xs text-gray-500">•</span>
                        <span
                            class="text-sm text-gray-500">{{ $post->created_at->locale('tr')->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-1 md:ml-1">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" wire:navigate wire:key="tag-{{ $tag->id }}"
                            class="{{ $this->getTagColor($tag->color) }} rounded-full px-2 py-1 text-xs font-medium capitalize text-white transition-all duration-100 hover:bg-opacity-90">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
            @auth
                @can('delete', $post)
                    <button @click="postId = {{ $post->id }}; deletePostModal = true; $dispatch('delete-post-modal-open')"
                        class="text-sm opacity-60 hover:opacity-100" title="Sil">
                        <x-icons.trash color="#ff6969" size="14" />
                    </button>
                @endcan
            @endauth
        </div>
        <article class="prose prose-sm max-w-none break-all sm:prose-base lg:prose-lg"
            wire:loading.class="animate-pulse" wire:target.except='toggleLike'>
            {!! $post->html !!}
        </article>
        @if ($post->polls->count() > 0)
            <div class="flex items-center gap-2">
                @php
                    $colors = ['bg-green-500', 'bg-yellow-500', 'bg-red-500', 'bg-indigo-500', 'bg-purple-500'];
                @endphp
                @foreach ($post->polls as $poll)
                    @php
                        // If color is already used, get another color
                        $randomColor = $colors[array_rand($colors)];
                        $colors = array_diff($colors, [$randomColor]);
                    @endphp
                    <button wire:key='poll-{{ $poll->id }}'
                        class="{{ $randomColor }} flex items-center gap-1 rounded-full px-2 py-1 text-xs font-medium text-white transition-all duration-300 hover:bg-opacity-90"
                        wire:click="$dispatch('openModal', { component: 'modals.show-poll-modal', arguments: { poll: {{ $poll }} }})">
                        <x-icons.survey color="white" size="18" />
                        <span>{{ $poll->question }}</span>
                    </button>
                @endforeach
            </div>
        @endif
        <div class="post-icon flex">
            <div class="flex items-center gap-0">
                @auth
                    <button class="rounded-full p-2 hover:bg-blue-200" @click="addCommentModal = true">
                        <x-icons.comment color="#4b5563" />
                    </button>
                @endauth
                @guest
                    <a class="rounded-full p-2 hover:bg-blue-100" href="{{ route('login') }}">
                        <x-icons.comment color="#4b5563" />
                    </a>
                @endguest
                <span class="font-light text-gray-600">{{ Number::abbreviate($post->getCommentsCount()) }}</span>
            </div>
            <div class="flex items-center gap-0">
                @auth
                    <button wire:loading.remove class="rounded-full p-2 hover:bg-blue-200" wire:click="toggleLike()">
                        @if (!$this->isLikedByUser())
                            <x-icons.heart />
                        @else
                            <x-icons.heart-off />
                        @endif
                    </button>
                    <x-icons.spinner color='#4b5563' size='6' wire:loading.flex wire:target="toggleLike"
                        class="flex items-center rounded-full p-2" />
                @endauth
                @guest
                    <a class="rounded-full p-2 hover:bg-blue-100" href="{{ route('login') }}">
                        <x-icons.heart />
                    </a>
                @endguest
                <span class="font-light text-gray-600">{{ Number::abbreviate($post->likes_count) }}</span>
            </div>
            <div class="flex items-center gap-0">
                <button class="rounded-full p-2 hover:bg-blue-200">
                    <x-icons.share color="#4b5563" />
                </button>
                <span class="font-light text-gray-600">392</span>
            </div>
        </div>
    </div>
</div>
