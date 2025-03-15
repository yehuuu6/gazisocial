<div x-data="{
    registerModal: false,
    message: '',
}" x-on:auth-required.window="registerModal = true; message = $event.detail.msg">
    <div class="px-1 py-3 md:p-6">
        <div x-init="() => {
            $el.scrollIntoView();
        }"
            class="flex items-center justify-between gap-1 md:gap-4 mx-2.5 mt-1 mb-3 py-2 px-4 md:mb-5 md:py-3 md:px-5 rounded-full border border-gray-200">
            @if ($parent::class === 'App\Models\Post')
                <span class="text-gray-600 min-w-fit font-normal text-xs md:text-sm">
                    Tek yorum gösteriliyor
                </span>
            @else
                <x-link href="{{ $parent->showRoute() }}" class="text-blue-400 min-w-fit font-normal text-xs md:text-sm">
                    Cevaplanan yorumu gör
                </x-link>
            @endif
            <hr class="w-full border-t border-gray-200">
            <a href="{{ $this->post->showRoute() . '#comments' }}"
                class="min-w-fit text-blue-400 font-normal text-xs md:text-sm hover:underline">
                Tüm yorumları gör
            </a>
        </div>
        <div class="px-2 pb-2">
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
                <div class="flex flex-col gap-1 md:gap-2.5">
                    @foreach ($this->comments as $comment)
                        <livewire:post.comment-item :$renderedReplyId :isSingleCommentThread="true" :$post :$comment
                            :key="'comment-' . $comment->id" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <x-user.register-modal />
</div>
