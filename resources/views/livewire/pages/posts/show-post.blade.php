@section('canonical')
    <link rel="canonical" href="{{ $post->showRoute() }}">
@endsection
<div x-data="{
    deleteCommentModal: false,
    addReplyModal: false,
    commentId: null,
    deletePostModal: false,
    postId: null,
}">
    <x-page-title>{{ $post->title }}</x-page-title>
    <div class="flex flex-col overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
        <livewire:components.post.details :$post lazy />
        <x-seperator />
        <h3 id="comment-header" class="p-4 text-xl font-bold">Yorumlar</h3>
        <ul wire:loading class="flex flex-1 flex-col gap-1 pb-5">
            @for ($i = 0; $i < 10; $i++)
                <x-comments.placeholder />
            @endfor
        </ul>
        <ul wire:loading.remove class="flex flex-1 flex-col gap-1 pb-5">
            @if ($comments->isEmpty())
                <li class="p-4 text-gray-500">Henüz yorum yapılmamış, ilk yorumu siz yapın!</li>
            @endif
            @foreach ($comments as $comment)
                <livewire:components.post.post-comment :$comment :key="$comment->id" />
            @endforeach
        </ul>
        {{ $comments->links('livewire.pagination.simple') }}
    </div>
    @auth
        <livewire:modals.create-reply-modal />
        <livewire:modals.delete-comment-modal />
        <livewire:modals.delete-post-modal />
    @endauth
</div>

@script
    <script>
        $wire.on('scroll-to-header', function() {
            const header = document.getElementById('comment-header');
            const offset = 75;
            const topPosition = header.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({
                top: topPosition,
                behavior: 'smooth'
            });
        });
    </script>
@endscript
