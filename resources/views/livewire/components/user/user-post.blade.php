<div class="w-full border border-gray-200 rounded-lg flex items-center gap-2 p-5 justify-between shadow-sm">
    <div class="flex lg:flex-row flex-col lg:items-center gap-0.5 lg:gap-1 hover:no-underline">
        <x-link href="{{ $post->showRoute() }}" class="text-xl text-blue-500">
            {{ $post->title }}
        </x-link>
        <span class="hidden lg:inline-block text-gray-500 text-xs">•</span>
        <span class="text-gray-500 text-sm">
            {{ $post->created_at->locale('tr')->diffForHumans() }} paylaşıldı.
        </span>
        <div class="flex gap-1.5 items-center mt-2 lg:ml-1 lg:mt-0 flex-wrap">
            @foreach ($post->tags as $tag)
                <x-link href="{{ route('category.show', $tag->slug) }}"
                    class="bg-{{ $tag->color }}-500 text-white py-1 px-2 rounded-full text-xs hover:no-underline">
                    {{ $tag->name }}
                </x-link>
            @endforeach
        </div>
    </div>
    @auth
        @can('delete', $post)
            <button @click="postId = {{ $post->id }}; deletePostModal = true; $dispatch('delete-post-modal-open')"
                class="text-sm text-red-300 self-start lg:self-auto font-mono hover:text-red-600">
                <x-icons.trash color="#ff6969" size="14" />
            </button>
        @endcan
    @endauth
</div>
