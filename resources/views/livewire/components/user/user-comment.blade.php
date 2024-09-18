<li class="w-full border border-gray-200 rounded-lg flex items-start gap-2 p-5 justify-between">
    <div class="flex flex-col gap-1">
        <div class="flex items-center gap-1">
            <x-link href="{{ $comment->post->showRoute() }}" class="text-xl text-blue-500">
                {{ $comment->post->title }}
            </x-link>
            <span class="inline-block text-gray-500 text-xs">•</span>
            <span class="text-gray-500 text-sm">
                {{ $comment->created_at->locale('tr')->diffForHumans() }} yorum yapıldı.
            </span>
        </div>
        <p class="text-gray-600 break-all">
            {{ $comment->content }}
        </p>
    </div>
    @auth
        @can('delete', $comment)
            <button wire:click='deleteComment' class="text-sm text-red-300 font-mono hover:text-red-600">
                Yorumu Sil
            </button>
        @endcan
    @endauth
</li>
