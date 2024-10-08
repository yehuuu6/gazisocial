<div class="flex flex-col justify-center gap-5 rounded-xl border border-gray-100 bg-white shadow-md">
    <livewire:components.post.reply-details :$comment :$post />
    <x-seperator />
    <h3 id="replies-header" class="p-4 text-xl font-bold">Yanıtlar</h3>
    <ul wire:loading class="flex flex-1 flex-col gap-1 pb-5">
        @for ($i = 0; $i < 10; $i++)
            <x-comments.placeholder />
        @endfor
    </ul>
    <ul wire:loading.remove class="flex flex-1 flex-col gap-1 pb-5">
        @if ($replies->isEmpty())
            <li class="p-4 text-gray-500">Henüz yorum yapılmamış, ilk yorumu siz yapın!</li>
        @endif
        @foreach ($replies as $reply)
            <livewire:components.post.comment-reply :$postAuthor :$reply :key="'reply-' . $reply->id" />
        @endforeach
    </ul>
    {{ $replies->links('livewire.pagination.simple') }}
</div>
