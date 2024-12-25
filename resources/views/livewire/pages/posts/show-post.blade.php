@section('canonical')
    <link rel="canonical" href="{{ $post->showRoute() }}">
@endsection
<div x-data="{
    deleteCommentModal: false,
    deleteReplyModal: false,
    addReplyModal: false,
    commentId: null,
    replyId: null,
    deletePostModal: false,
    postId: null,
}">
    <x-page-title>{{ $post->title }}</x-page-title>
    <div class="flex flex-col overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
        <livewire:components.post.details :$post />
        <x-seperator />
        <livewire:pages.posts.list-post-comments :$post lazy />
    </div>
    @auth
        <livewire:modals.create-reply-modal />
        <livewire:modals.delete-comment-modal />
        <livewire:modals.delete-reply-modal />
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
