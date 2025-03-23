@props(['comment', 'user_id', 'is_anonim' => false])
<div>
    <div class="flex items-center gap-1.5 flex-wrap">
        <x-link href="{{ route('users.show', $comment->user) }}" class="font-bold text-xs text-gray-800">
            {{ $comment->user->name }}
        </x-link>
        @if ($comment->user_id === $user_id && !$is_anonim)
            <span class="text-xs text-blue-700 font-semibold">
                Yazar
            </span>
        @endif
        <span class="text-xs text-gray-500">•</span>
        <span class="text-xs text-gray-500">
            {{ $comment->created_at->locale('tr')->shortAbsoluteDiffForHumans() }} önce
        </span>
    </div>
    @if ($comment->user->strongRole()->level > 0)
        <span
            class="text-xs px-2 py-0.5 bg-{{ $comment->user->strongRole()->color }}-500 text-white rounded-full font-semibold">
            {{ $comment->user->strongRole()->name }}
        </span>
    @endif
</div>
