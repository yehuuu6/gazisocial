<div>
    <div x-data="{
        showReplies: {{ $comment->depth }} < 3 ? true : false,
        replyForm: false,
        openMoreCommentButtons: false,
        likeCount: $wire.likesCount,
        isLiked: $wire.isLiked,
        toggleLike() {
            $wire.toggleLike(); // Call the wire method to toggle the like status behind the scenes
            // If user is authenticated, update the like count and status on the client side
            if ($wire.isAuthenticated) {
                if (!this.isLiked) {
                    this.likeCount++;
                    this.isLiked = true;
                } else {
                    this.likeCount--;
                    this.isLiked = false;
                }
            }
        }
    }" x-init="$wire.on('view-replies.{{ $comment->id }}', () => {
        showReplies = true;
    })">
        <div :class="{ 'mt-2.5': {{ $comment->depth }} > 0 }">
            <div class="flex items-center gap-2 w-fit pr-3" x-ref="comment{{ $comment->id }}">
                <div class="relative">
                    <img x-ref="avatar" class="size-8 object-cover rounded-full shadow self-start"
                        src="{{ asset($comment->user->avatar) }}" alt="avatar">
                    @if ($comment->depth > 0)
                        <div
                            class="absolute inset-0 -top-1.5 -left-6 border-b border-l z-0 rounded-bl-xl size-6 border-gray-200">
                        </div>
                    @endif
                </div>
                <x-comment.comment-details :$comment :user_id="$post->user_id" />
            </div>
            <div class="relative">
                @if ($comment->replies_count > 0)
                    <div x-on:click="
                      $refs.avatar.scrollIntoView({ behavior: 'smooth', block: 'center' });
                      const comment = $refs.comment{{ $comment->id }};
                      comment.classList.add('highlight');
                      setTimeout(() => comment.classList.remove('highlight'), 2000);"
                        class="absolute top-0 bottom-0 left-4 w-4 mb-5 z-[1] group">
                        <div
                            class="w-full h-full border-l border-gray-200 group-hover:border-l-2 group-hover:border-gray-500 cursor-pointer">
                        </div>
                    </div>
                @endif
                <div class="ml-10">
                    <div class="flex flex-col gap-1" x-on:click.away="replyForm = false;">
                        @if ($comment->content)
                            <p class="text-gray-800 break-all">{{ $comment->content }}</p>
                        @endif
                        @if ($comment->gif_url)
                            <img src="{{ asset($comment->gif_url) }}" alt="GIF"
                                class="h-32 md:h-64 max-w-fit object-cover rounded-lg">
                        @endif
                        <div class="relative flex items-center gap-0.5 mt-2 flex-wrap">
                            @if ($comment->replies_count > 0)
                                <div class="absolute -left-[41px] z-10">
                                    <x-ui.tooltip text="Yanıtları gizle/göster" position="right" delay="1000">
                                        <button
                                            class="active:bg-gray-300 px-2 grid place-items-center bg-white rounded-full text-gray-700"
                                            x-on:click="showReplies = !showReplies;">
                                            <div x-cloak x-show="!showReplies">
                                                <x-icons.show size="18" />
                                            </div>
                                            <div x-cloak x-show="showReplies">
                                                <x-icons.hide size="18" />
                                            </div>
                                        </button>
                                    </x-ui.tooltip>
                                </div>
                            @endif
                            <x-comment.comment-button x-on:click="toggleLike()">
                                <div :class="{ 'text-pink-400': isLiked }">
                                    <template x-if="isLiked">
                                        <x-icons.heart-off size="20" />
                                    </template>
                                    <template x-if="!isLiked">
                                        <x-icons.heart size="20" />
                                    </template>
                                </div>
                                <span class="ml-0.5" x-text="likeCount" :class="{ 'text-pink-400': isLiked }">
                                    0
                                </span>
                            </x-comment.comment-button>
                            <x-comment.comment-button x-on:click="replyForm = !replyForm;">
                                <x-icons.comment size="20" />
                                <span>Yanıtla</span>
                            </x-comment.comment-button>
                            <x-comment.comment-button x-on:click="alert('Not implemented yet!');">
                                <x-icons.send size="20" />
                                <span>Paylaş</span>
                            </x-comment.comment-button>
                            <x-comment.comment-button x-on:click="openMoreCommentButtons = !openMoreCommentButtons;"
                                x-ref="moreButton">
                                <x-icons.dots size="18" />
                            </x-comment.comment-button>
                            <x-comment.comment-dropdown :$comment />
                        </div>
                        <template x-if="replyForm" x-on:comment-added.window="replyForm = false">
                            <x-comment.forms.reply-form :$comment />
                        </template>
                    </div>
                </div>
                {{-- Recursive component for replies --}}
                <div x-cloak x-show="showReplies" class="space-y-2.5 ml-10">
                    @if ($comment->depth <= 10)
                        @foreach ($comment->loadReplies($maxReplyCount) as $reply)
                            <livewire:post.comment-item :$post :comment="$reply" :key="'reply-' . $reply->id" lazy />
                        @endforeach
                    @endif
                </div>
                @if ($comment->replies_count > $maxReplyCount)
                    <x-comment.continue-thread :more_replies_count="$comment->replies_count - $maxReplyCount" />
                @endif
            </div>
        </div>
    </div>

</div>
