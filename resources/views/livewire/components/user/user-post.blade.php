<div class="flex flex-col p-4">
    <div class="flex justify-between items-center">
        <x-link href="/posts/{{ $post->slug }}" class="text-lg font-medium text-blue-500">{{ $post->title }}</x-link>
        <span class="text-gray-500">{{ $post->created_at->locale('tr')->diffForHumans() }}</span>
    </div>
    <p class="mt-2 text-gray-500 break-all line-clamp-1">{{ $post->content }}</p>
</div>
