<div x-data="{
    registerModal: false,
    message: '',
}" x-on:auth-required.window="registerModal = true; message = $event.detail.msg">
    <div class="px-1 py-3 md:p-6">
        <div x-init="() => {
            $el.scrollIntoView();
        }"
            class="flex items-center justify-between gap-1 md:gap-4 mx-1.5 mt-1 mb-3 py-2 px-4 md:mx-6 md:mb-3 md:py-3 md:px-5 rounded-full border border-gray-200">
            <span class="text-gray-600 min-w-fit font-normal text-xs md:text-sm">
                Tek yorum gösteriliyor
            </span>
            <hr class="w-full border-t border-gray-200">
            <x-link href="{{ $this->post->showRoute() }}" class="min-w-fit text-blue-400 font-normal text-xs md:text-sm">
                Tüm yorumları gör
            </x-link>
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
                <div class="flex flex-col gap-1 md:gap-2.5 overflow-x-hidden">
                    @foreach ($this->comments as $comment)
                        <livewire:post.comment-item :isSingleCommentThread="true" :$post :$comment :key="'comment-' . $comment->id" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <x-user.register-modal wire:modal="registerModal" />
</div>
