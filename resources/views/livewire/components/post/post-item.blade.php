<div class="flex flex-col p-2 md:p-4">
    <div class="flex justify-between items-center">
        <div class="flex gap-2 items-center">
            <x-link title="{{ $post->user->name }}" href="/u/{{ $post->user->username }}">
                <img class="size-7 md:size-8 rounded-full" src="{{ $post->user->avatar }}" alt="avatar">
            </x-link>
            <x-link href="/posts/{{ $post->slug }}"
                class="text-base md:text-lg font-medium text-blue-800">{{ $post->title }}</x-link>
        </div>
        <span class="text-gray-500 text-xs md:text-sm">{{ $post->created_at->diffForHumans() }}</span>
    </div>
    <p class="ml-2 mt-2 text-gray-500 break-all text-sm md:text-base line-clamp-1">{{ $post->content }}</p>
    <div class="post-icon flex ml-2 mt-3">
        <div class="flex gap-1 items-center">
            <x-icons.comment color="#4b5563" />
            <p class="text-gray-600 font-light text-xs md:text-sm">{{ $post->comments_count }}</p>
        </div>
        <div class="flex gap-1 items-center">
            <x-icons.heart color="#4b5563" />
            <p class="text-gray-600 font-light text-xs md:text-sm">{{ $post->comments_count }}</p>
        </div>
        <div class="flex gap-1 items-center">
            <x-icons.share color="#4b5563" />
            <p class="text-gray-600 font-light text-xs md:text-sm">{{ $post->comments_count }}</p>
        </div>
    </div>
</div>
