<div x-data="{ deleteReplyModal: false, commentId: {{ $comment->id }} }"
    class="flex flex-col justify-center gap-5 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
    <livewire:components.post.reply-details :$comment :$post />
    @auth
        <livewire:modals.delete-reply-modal />
    @endauth
    <x-seperator />
    <h3 id="replies-header" class="px-4 text-xl font-bold">
        Yanıtlar
        <span class="text-sm md:text-base ml-0.5 md:ml-1 font-normal text-gray-500">
            En eski
        </span>
    </h3>
    <ul wire:loading class="flex flex-1 flex-col gap-1 pb-5">
        @for ($i = 0; $i < 10; $i++)
            <x-comments.placeholder />
        @endfor
    </ul>
    <ul wire:loading.remove class="flex flex-1 flex-col gap-1 pb-2">
        @if ($replies->isEmpty())
            <li class="p-4 text-gray-500">Henüz yorum yapılmamış, ilk yorumu siz yapın!</li>
        @endif
        @if ($latestCreatedReply)
            <livewire:components.post.comment-reply type="full-page" :$postAuthor :isNew="true" :reply="$latestCreatedReply"
                :key="'latest-reply-' . $latestCreatedReply->id" />
        @endif
        @foreach ($replies as $reply)
            @if ($latestCreatedReply && $reply->id === $latestCreatedReply->id)
                @continue
            @endif
            <livewire:components.post.comment-reply type="full-page" :$postAuthor :$reply :key="'reply-' . $reply->id" />
        @endforeach
    </ul>
    {{ $replies->links('livewire.pagination.simple') }}
</div>
@script
    <script>
        $wire.on('scroll-to-header', function() {
            const header = document.getElementById('replies-header');
            const offset = 75;
            const topPosition = header.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({
                top: topPosition,
                behavior: 'smooth'
            });
        });
    </script>
@endscript
