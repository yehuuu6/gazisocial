<div class="flex gap-3 p-5">
    <img src="{{ asset($post->user->avatar) }}" alt="avatar" class="w-8 h-8 rounded-full">
    <div class="w-full flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <div class="flex gap-1 items-baseline">
                <x-link href="/u/{{ $post->user->username }}" class="font-medium">
                    {{ $post->user->name }}
                </x-link>
                <p class="text-sm text-gray-500">{{ $username }}</p>
            </div>
            <p class="text-sm text-gray-500">{{ $time }}</p>
        </div>
        <h1 class="font-medium text-gray-900 text-2xl">{{ $post->title }}</h1>
        <article class="text-gray-600" wire:loading.class="animate-pulse">
            {{ $post->content }}
        </article>
        <div class="post-icon flex">
            @auth
                <button
                    wire:click="$dispatch('openModal', { component: 'modals.comment-modal', arguments: { post: {{ $post->id }} }})">
                    <x-icons.comment />
                </button>
            @endauth
            @guest
                <a href="{{ route('login') }}">
                    <x-icons.comment />
                </a>
            @endguest
            <x-icons.heart />
            <x-icons.share />
        </div>
    </div>
</div>
