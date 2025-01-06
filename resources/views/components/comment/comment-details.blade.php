<div class="flex items-center gap-1 flex-wrap">
    <x-link href="{{ route('users.show', $comment->user) }}" class="font-semibold text-sm text-gray-700">
        {{ $comment->user->name }}
    </x-link>
    @if ($comment->user_id === $post->user_id)
        <span class="text-xs bg-blue-500 px-2 text-white py-1 rounded-full ml-1">GS</span>
    @else
        <span class="text-xs text-gray-500">
            {{ '@' . $comment->user->username }}
        </span>
    @endif
    <span class="text-xs text-gray-500">•</span>
    <span class="text-xs text-gray-500">
        {{ $comment->created_at->locale('tr')->diffForHumans() }}
    </span>
</div>
