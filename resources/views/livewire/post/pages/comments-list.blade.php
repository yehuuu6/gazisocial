<div x-data="{
    registerModal: false,
    message: '',
    gifSelector: false,
}" x-on:auth-required.window="registerModal = true; message = $event.detail.msg">
    <div class="p-1 md:p-6">
        <div class="p-3 md:p-0">
            <div x-ref="commentForm" class="scroll-mt-24" x-on:click.away="commentForm = false"
                x-on:updating-comments-page.window="$refs.commentForm.scrollIntoView({ behavior: 'smooth' })">
                <div x-show="!commentForm">
                    <button x-on:click="commentForm = true"
                        class="rounded-3xl w-full py-2 md:py-3 px-3 md:px-4 border border-gray-300 hover:border-gray-400 text-sm text-gray-500 font-normal cursor-text text-left">
                        Yorum ekle
                    </button>
                </div>
                <div x-cloak x-show="commentForm" x-on:comment-added.window="commentForm = false">
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
                <button x-on:click="alert('Not implemented yet!')"
                    class="text-gray-600 font-light text-xs md:text-sm px-2 md:px-4 py-2 flex items-center gap-2.5 rounded-full border border-gray-300 hover:border-gray-400"
                    type="button">
                    <x-icons.search size="17" />
                    <span>Yorumlarda Ara</span>
                </button>
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
    <x-user.register-modal wire:modal="registerModal" />
</div>
