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
        <livewire:components.post.details :$post lazy />
        <x-seperator />
        <div class="p-4 flex items-center justify-between">
            <h3 id="comment-header" class="text-xl font-bold">
                Yorumlar
                <span class="text-sm md:text-base ml-0.5 md:ml-1 font-normal text-gray-500">
                    @if ($commentSortType === 'popularity')
                        En beğenilen
                    @elseif ($commentSortType === 'latest')
                        En yeni
                    @endif
                </span>
            </h3>
            <div class="flex items-center gap-1 relative" x-data="{ open: false }">
                <button x-ref="commentSortToggle" @click="open = !open"
                    class="rounded-md px-3 py-2 border-gray-200 text-gray-700 text-sm border flex items-center gap-0.5">
                    <x-icons.filter size="14" color="#131313" />
                    <span class="mx-1">Sıralama ölçütü</span>
                    <template x-if="open">
                        <x-icons.chevron-up size="12" color="black" />
                    </template>
                    <template x-if="!open">
                        <x-icons.chevron-down size="12" color="black" />
                    </template>
                </button>
                <div x-cloak x-show="open" @click.away="open = false" x-transition.origin.top.right.duration.200ms
                    x-anchor.bottom-start="$refs.commentSortToggle"
                    class="z-10 mt-1 gap-0.5 w-full min-w-max whitespace-nowrap shadow-sm rounded-lg border border-gray-200 bg-white">
                    <div class="flex flex-col gap-1 p-1.5">
                        <button wire:click="sortBy('popularity')" @click="open = false"
                            class="flex @if ($commentSortType === 'popularity') bg-gray-100 @endif text-gray-600 items-center gap-2 rounded-md px-4 py-2 text-sm font-normal capitalize hover:bg-[#E5E7EB]/50 hover:no-underline">
                            En Beğenilen
                        </button>
                        <button wire:click="sortBy('latest')" @click="open = false"
                            class="flex @if ($commentSortType === 'latest') bg-gray-100 @endif text-gray-600 items-center gap-2 rounded-md px-4 py-2 text-sm font-normal capitalize hover:bg-[#E5E7EB]/50 hover:no-underline">
                            En Yeni
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
