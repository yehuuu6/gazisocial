<div class="flex gap-3 p-5">
    <img src="{{ asset($post->user->avatar) }}" alt="avatar" class="w-8 h-8 rounded-full">
    <div class="w-full flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <div class="flex gap-1 items-baseline">
                <x-link href="/u/{{ $post->user->username }}" class="font-medium">
                    {{ $post->user->name }}
                </x-link>
                <p class="text-sm text-gray-500">{{ '@' . $post->user->username }}</p>
                <span class="text-gray-500 text-xs">&#x2022;</span>
                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
            </div>
            @auth
                @can('delete', $post)
                    <button
                        wire:click="$dispatch('openModal', { component: 'modals.delete-post-modal', arguments: { postId: {{ $post->id }} }})"
                        class="text-sm opacity-60 hover:opacity-100" title="Sil">
                        <x-icons.trash color="#ff6969" size="14" />
                    </button>
                @endcan
            @endauth
        </div>
        <h1 class="font-medium text-gray-900 text-2xl">{{ $post->title }}</h1>
        <article class="text-gray-600 break-all" wire:loading.class="animate-pulse">
            {{ $post->content }}
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
                        class="{{ $randomColor }} text-white py-1 px-2 text-xs font-medium rounded-full"
                        wire:click="$dispatch('openModal', { component: 'modals.show-poll-modal', arguments: { poll: {{ $poll }} }})">
                        {{ $poll->question }}
                    </button>
                @endforeach
            </div>
        @endif
        <div class="post-icon flex">
            @auth
                <div class="flex gap-0 items-center">
                    <button class="hover:bg-blue-200 p-2 rounded-full"
                        wire:click="$dispatch('openModal', { component: 'modals.comment-modal', arguments: { post: {{ $post }} }})">
                        <x-icons.comment color="#4b5563" />
                    </button>
                    <p class="text-gray-600 font-light">{{ $post->comments->count() }}</p>
                </div>
            @endauth
            @guest
                <div class="flex gap-0 items-center">
                    <a class="hover:bg-blue-100 p-2 rounded-full" href="{{ route('login') }}">
                        <x-icons.comment color="#4b5563" />
                    </a>
                    <p class="text-gray-600 font-light">{{ $post->comments->count() }}</p>
                </div>
            @endguest
            <div class="flex gap-0 items-center">
                <button class="hover:bg-blue-200 rounded-full p-2">
                    <x-icons.heart color="#4b5563" />
                </button>
                <p class="text-gray-600 font-light">5.351</p>
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
