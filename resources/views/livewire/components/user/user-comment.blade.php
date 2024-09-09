<li class="w-full border border-gray-200 rounded-lg flex flex-col gap-2 p-5 justify-center">
    <div class="bg-gray-100 flex items-center justify-between rounded-full text-sm px-3 py-1">
        <div>
            <x-link href="/posts/{{ Str::slug($comment->post->title) }}" class=" text-blue-500">
                {{ $comment->post->title }}
            </x-link>
            <span class="ml-1 text-gray-600">
                adlı konuya {{ $comment->created_at->locale('tr')->diffForHumans() }} yorum yaptı.
            </span>
        </div>
        @auth
            @can('delete', $comment)
                <button wire:click='deleteComment' class="text-sm text-red-300 font-mono hover:text-red-600">
                    Yorumu Sil
                </button>
            @endcan
        @endauth
    </div>
    <p class="text-gray-600 break-all">{{ $comment->content }}</p>
</li>
