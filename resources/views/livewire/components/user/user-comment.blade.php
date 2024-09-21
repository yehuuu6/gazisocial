<li class="w-full border border-gray-200 rounded-lg flex items-start gap-2 p-5 justify-between shadow-sm">
    <div class="flex flex-col gap-2">
        <div class="flex md:items-center flex-col md:flex-row gap-0.5 md:gap-1">
            <x-link href="{{ $comment->post->showRoute() }}" class="self-start text-xl text-blue-500">
                {{ $comment->post->title }}
            </x-link>
            <span class="hidden md:inline-block text-gray-500 text-xs">•</span>
            <span class="text-gray-500 text-sm">
                {{ $comment->created_at->locale('tr')->diffForHumans() }} yorum yapıldı.
            </span>
        </div>
        <p class="text-gray-600 break-all line-clamp-4 md:line-clamp-2">
            {{ $comment->content }}
        </p>
    </div>
    @auth
        @can('delete', $comment)
            <button @click="commentId = {{ $comment->id }}; deleteCommentModal = true; $dispatch('delete-comment-modal-open')"
                class="text-sm text-red-300 font-mono hover:text-red-600">
                <x-icons.trash color="#ff6969" size="14" />
            </button>
        @endcan
    @endauth
</li>
