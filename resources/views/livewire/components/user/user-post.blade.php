<div class="w-full border border-gray-200 rounded-lg flex items-center gap-2 p-5 justify-between">
    <div class="flex items-center gap-1 hover:no-underline">
        <x-link href="{{ $post->showRoute() }}" class="text-xl text-blue-500">
            {{ $post->title }}
        </x-link>
        <span class="inline-block text-gray-500 text-xs">•</span>
        <span class="text-gray-500 text-sm">
            {{ $post->created_at->locale('tr')->diffForHumans() }} paylaşıldı.
        </span>
    </div>
    @auth
        @can('delete', $post)
            <button wire:click='deletePost' class="text-sm text-red-300 font-mono hover:text-red-600">
                Gönderiyi Sil
            </button>
        @endcan
    @endauth
</div>
