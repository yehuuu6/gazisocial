<div class="flex flex-col p-4">
    <div class="flex justify-between items-center">
        <x-link href="/posts/{{ Str::slug($post->title) }}"
            class="text-lg font-medium text-blue-500">{{ $post->title }}</x-link>
        <span class="text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
    </div>
    <p class="mt-2 text-gray-500 break-all">{{ Str::limit($post->content, 150, '...') }}</p>
</div>
