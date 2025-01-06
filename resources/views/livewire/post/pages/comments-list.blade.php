<div x-data="{
    registerModal: false,
    message: '',
}" x-on:auth-required.window="registerModal = true; message = $event.detail.msg">
    <div class="p-6">
        <div>
            <div x-ref="commentForm" class="scroll-mt-24"
                x-on:updating-comments-page.window="$refs.commentForm.scrollIntoView({ behavior: 'smooth' })">
                <template x-if="!commentForm">
                    <button x-on:click="commentForm = true"
                        class="rounded-3xl w-full py-3 px-4 border border-gray-300 hover:border-gray-400 text-sm text-gray-500 font-normal cursor-text text-left">
                        Yorum ekle
                    </button>
                </template>
                <template x-if="commentForm" x-on:comment-added.window="commentForm = false">
                    <x-comment.forms.comment-form />
                </template>
            </div>
            <div class="my-4 flex gap-1.5 items-center">
                <span class="text-gray-600 font-normal text-xs">Sıralama Ölçütü:</span>
                <x-ui.tooltip text="Sıralama seçeneklerini aç" position="bottom" delay="1000">
                    <button x-on:click="alert('Sıralama seçenekleri açılacak')"
                        class="px-4 py-2 flex items-center gap-2 text-gray-600 font-medium text-xs rounded-full hover:bg-gray-100 active:bg-gray-300 focus:bg-gray-200"
                        type="button">
                        <span>En Yeniler</span>
                        <x-icons.arrow-down size="18" />
                    </button>
                </x-ui.tooltip>
                <button x-on:click="alert('Yorumlarda arama yapılacak')"
                    class="text-gray-600 font-light text-sm px-4 py-2 flex items-center gap-2.5 rounded-full border border-gray-300 hover:border-gray-400"
                    type="button">
                    <x-icons.search size="17" />
                    <span>Yorumlarda Ara</span>
                </button>
            </div>
        </div>
        <div class="px-2">
            @if (!$this->comments->isNotEmpty())
                <div class="flex gap-3 items-center">
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
                <div class="space-y-2.5">
                    @foreach ($this->comments as $comment)
                        <livewire:post.comment-item :$post :$comment :key="'comment-' . $comment->id" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    {{ $this->comments->links('livewire.pagination.simple') }}
    <x-user.register-modal wire:modal="registerModal" />
</div>
