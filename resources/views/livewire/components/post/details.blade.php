<div x-data="{ addCommentModal: false }" class="flex gap-2 p-3 sm:gap-4 sm:p-5">
    @auth
        <livewire:modals.create-comment-modal :$post />
    @endauth
    <img src="{{ asset($post->user->avatar) }}" alt="avatar" class="size-10 sm:size-12 rounded-full">
    <div class="w-full flex gap-2 flex-col sm:gap-4">
        <div class="flex justify-between items-center">
            <div class="flex gap-1 flex-col-reverse sm:flex-row items-baseline">
                <div class="flex flex-col sm:flex-row gap-1">
                    <x-link href="/u/{{ $post->user->username }}" class="font-medium">
                        {{ $post->user->name }}
                    </x-link>
                    <div class="flex items-center gap-1">
                        <p class="text-sm text-gray-500">{{ '@' . $post->user->username }}</p>
                        <span class="inline-block text-gray-500 text-xs">•</span>
                        <p class="text-sm text-gray-500">{{ $post->created_at->locale('tr')->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="md:ml-1 flex items-center gap-1 flex-wrap">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" wire:navigate wire:key="tag-{{ $tag->id }}"
                            class="py-1 px-2 {{ $this->getTagColor($tag->color) }} text-white transition-all duration-100 font-medium rounded-full capitalize text-xs hover:bg-opacity-90">{{ $tag->name }}</a>
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
        <article class="prose prose-sm sm:prose-base lg:prose-lg max-w-none" wire:loading.class="animate-pulse"
            wire:target.except='toggleLike'>
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
                        class="{{ $randomColor }} text-white transition-all duration-300 py-1 px-2 text-xs font-medium rounded-full flex items-center hover:bg-opacity-90 gap-1"
                        wire:click="$dispatch('openModal', { component: 'modals.show-poll-modal', arguments: { poll: {{ $poll }} }})">
                        <x-icons.survey color="white" size="18" />
                        <span>{{ $poll->question }}</span>
                    </button>
                @endforeach
            </div>
        @endif
        <div class="post-icon flex">
            <div class="flex gap-0 items-center">
                @auth
                    <button class="hover:bg-blue-200 p-2 rounded-full" @click="addCommentModal = true">
                        <x-icons.comment color="#4b5563" />
                    </button>
                @endauth
                @guest
                    <a class="hover:bg-blue-100 p-2 rounded-full" href="{{ route('login') }}">
                        <x-icons.comment color="#4b5563" />
                    </a>
                @endguest
                <p class="text-gray-600 font-light">{{ Number::abbreviate($post->comments_count) }}</p>
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
                <p class="text-gray-600 font-light">{{ Number::abbreviate($post->likes_count) }}</p>
            </div>
            <div class="flex gap-0 items-center">
                <button class="hover:bg-blue-200 rounded-full p-2">
                    <x-icons.share color="#4b5563" />
                </button>
                <p class="text-gray-600 font-light">392</p>
            </div>
        </div>
    </div>
</div>
