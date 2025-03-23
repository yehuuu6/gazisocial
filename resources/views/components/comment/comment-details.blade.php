@props(['comment', 'user_id', 'is_anonim' => false])
<div :class="{ 'mb-1': {{ $comment->gif_url ? 'true' : 'false' }} }">
    <div class="flex items-center gap-1 flex-wrap">
        <x-link href="{{ route('users.show', $comment->user) }}" class="font-semibold text-xs md:text-sm text-gray-700">
            {{ $comment->user->name }}
        </x-link>
        <span class="hidden md:inline-block text-xs text-gray-500">
            {{ '@' . $comment->user->username }}
        </span>
        <span class="text-xs text-gray-500">•</span>
        <span class="text-xs text-gray-500">
            {{ $comment->created_at->locale('tr')->diffForHumans() }}
        </span>
    </div>
    @if ($comment->user->strongRole()->level > 0)
        <span
            class="text-xs px-2 py-0.5 bg-{{ $comment->user->strongRole()->color }}-500 text-white rounded-full font-semibold">
            {{ $comment->user->strongRole()->name }}
        </span>
    @endif
</div>
