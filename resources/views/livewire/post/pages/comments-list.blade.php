<div x-data="{
    gifSelector: false,
}" x-on:toggle-comment-form.window="$wire.commentForm = true;">
    <div class="p-1 md:p-6">
        <div class="p-3 md:p-0">
            <div x-ref="addCommentForm" class="scroll-mt-24" x-on:click.outside="$wire.commentForm = false"
                x-on:updating-comments-page.window="$refs.addCommentForm.scrollIntoView({ behavior: 'smooth' })">
                <div wire:show="!commentForm">
                    <button x-on:click="$wire.commentForm = true"
                        class="rounded-3xl w-full py-2 md:py-3 px-3 md:px-4 border border-gray-300 hover:border-gray-400 text-sm text-gray-500 font-normal cursor-text text-left">
                        Yorum ekle
                    </button>
                </div>
                <div x-cloak wire:show="commentForm">
                    <x-comment.forms.comment-form />
                </div>
            </div>
            <div x-data="{
                sortDropdown: false,
                selectedSort: $wire.sortBy,
                sortMap: {
                    'popularity': 'Popüler',
                    'newest': 'Yeni',
                    'oldest': 'Eski',
                },
            }" class="my-2 md:my-4 flex gap-1.5 items-center flex-wrap">
                <span class="text-gray-600 font-normal text-xs">Sıralama Ölçütü:</span>
                <x-comment.comment-sort />
            </div>
        </div>
        <div class="px-2 pb-2">
            @if (!$this->comments->isNotEmpty())
                <div class="flex gap-3 md:items-center flex-col md:flex-row">
                    <div>
                        <img src="{{ asset('discussion.png') }}" alt="start convo" class="size-20">
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-600 text-base mb-3">İlk yorum yapan siz olun</h3>
                        <p class="text-gray-500 font-normal text-sm">
                            Bu gönderiye henüz yorum yapılmamış.
                            <br>
                            Tartışmayı başlatmak için ilk yorumu siz yapın.
                        </p>
                    </div>
                </div>
            @else
                <div class="flex flex-col gap-1 md:gap-2.5">
                    @foreach ($this->comments as $comment)
                        <livewire:post.comment-item :$post :$comment :key="'comment-' . $comment->id" lazy />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    {{ $this->comments->links('livewire.pagination.simple') }}
    <x-user.register-modal />
</div>
