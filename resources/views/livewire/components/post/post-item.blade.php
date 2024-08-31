<div class="flex flex-col p-4">
    <div class="flex justify-between items-center">
        <div class="flex gap-2 items-center">
            <x-link title="{{ $post->user->name }}" href="/u/{{ $post->user->username }}">
                <img class="h-8 w-8 rounded-full" src="{{ $post->user->avatar }}" alt="avatar">
            </x-link>
            <x-link href="/posts/{{ Str::slug($post->title) }}"
                class="text-lg font-medium text-blue-800">{{ $post->title }}</x-link>
        </div>
        <span class="text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
    </div>
    <p class="ml-2 mt-2 text-gray-500">{{ Str::limit($post->content, 300, '...') }}</p>
    <div class="post-icon flex ml-2 mt-3">
        <x-icons.comment />
        <x-icons.heart />
        <x-icons.share />
    </div>
</div>
