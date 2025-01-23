<div>
    <div x-data="{
        showReplies: true,
        replyForm: false,
        openMoreCommentButtons: false,
        openShareDropdown: false,
        likeCount: $wire.likesCount,
        isLiked: $wire.isLiked,
        isMobile() {
            const regex = /Mobi|Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i;
            return regex.test(navigator.userAgent);
        },
        toggleRepliesVisibility() {
            // If the client is mobile, and the depth is more than 2, go to the home page
            if (this.isMobile() && {{ $comment->depth }} >= 2) {
                window.location.href = '{{ $comment->showRoute() }}';
            } else {
                this.showReplies = !this.showReplies;
            }
        },
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
        },
        setShowReplies() {
            // If the client is mobile, and the depth is less than 2, show the replies
            if (this.isMobile() && {{ $comment->depth }} < 2) {
                return true;
            }
            // If the client is not mobile and the depth is less than 3, show the replies
            if (!this.isMobile() && {{ $comment->depth }} < 3) {
                return true;
            }
            return false;
        },
    }" x-init="showReplies = setShowReplies();
    $wire.on('view-replies.{{ $comment->id }}', () => {
        // If the client is mobile, and the depth is more than 2, go to the comments page
        // To prevent the screen from beign over-crowded by replies in mobile devices
        if (isMobile() && {{ $comment->depth }} >= 2) {
            window.location.href = '{{ $comment->showRoute() }}';
        }
    
        showReplies = true;
    })">
        <div :class="{ 'mt-2.5': {{ $comment->depth }} > 0 }">
            <div class="flex items-center gap-1 md:gap-2 w-fit pr-1" x-ref="comment{{ $comment->id }}">
                <div class="relative">
                    <div class="size-7 md:size-8 relative md:static shadow rounded-full overflow-hidden">
                        <img x-ref="avatar" class="absolute md:static z-[1] w-full h-full object-cover"
                            src="{{ asset($comment->user->avatar) }}" alt="avatar" />
                    </div>
                    @if ($comment->depth > 0)
                        <div
                            class="absolute inset-0 -top-2 md:-top-1.5 -left-3 md:-left-6 border-b border-l z-0 rounded-bl-xl size-6 border-gray-200">
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
                <div class="pl-8 md:pl-10 pr-1">
                    <div x-data="{ showMore: false, isClamped: false }" class="flex flex-col gap-1" x-on:click.away="replyForm = false;">
                        @if ($comment->content)
                            <p x-ref="commentContent" :class="{ 'line-clamp-5': !showMore }"
                                class="text-sm pr-1 md:text-base text-gray-800 md:line-clamp-none break-all">
                                {{ $comment->content }}
                            </p>
                            <div x-init="isClamped = $refs.commentContent.scrollHeight > $refs.commentContent.clientHeight;">
                                <template x-if="isClamped">
                                    <div class="w-full flex items-center justify-end md:hidden">
                                        <button x-on:click="showMore = !showMore" type="button"
                                            x-text="showMore ? 'Gizle' : 'Devamını oku'"
                                            class="text-gray-700 text-sm mt-1 mr-2">
                                            Devamını oku
                                        </button>
                                    </div>
                                </template>
                            </div>
                        @endif
                        @if ($comment->gif_url)
                            <img src="{{ asset($comment->gif_url) }}" alt="GIF"
                                class="h-32 md:h-64 max-w-fit object-cover rounded-lg pr-1 mt-1">
                        @endif
                        <div class="relative flex items-center gap-2 md:gap-0.5 md:mt-2 flex-wrap">
                            @if ($comment->replies_count > 0)
                                <div class="absolute -left-[33px] md:-left-[41px] z-10">
                                    <x-ui.tooltip text="Yanıtları gizle/göster" position="right" delay="1000">
                                        <button
                                            class="active:bg-gray-300 px-2 grid place-items-center bg-white rounded-full text-gray-700"
                                            x-on:click="toggleRepliesVisibility()">
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
                                <span>{{ Number::abbreviate($comment->replies_count) }}</span>
                            </x-comment.comment-button>
                            <x-comment.comment-button x-on:click="openShareDropdown = !openShareDropdown"
                                x-ref="shareButton">
                                <x-icons.send size="20" />
                                <span class="hidden md:inline-block">Paylaş</span>
                            </x-comment.comment-button>
                            <x-comment.comment-share-dropdown :url="$comment->showRoute()" />
                            <x-comment.comment-button x-on:click="openMoreCommentButtons = !openMoreCommentButtons;"
                                x-ref="moreButton">
                                <x-icons.dots size="20" />
                            </x-comment.comment-button>
                            <x-comment.comment-more-dropdown :$comment />
                        </div>
                        <template x-if="replyForm" x-on:comment-added.window="replyForm = false">
                            <x-comment.forms.reply-form :$comment />
                        </template>
                    </div>
                </div>
                {{-- Recursive component for replies --}}
                <div x-cloak x-show="showReplies" class="flex flex-col gap-0 pl-7 md:pl-10">
                    @if ($comment->depth <= 10)
                        @foreach ($comment->loadReplies($maxReplyCount) as $reply)
                            <livewire:post.comment-item :$isSingleCommentThread :depth="$depth + 1" :$post
                                :comment="$reply" :key="'reply-' . $reply->id" lazy />
                        @endforeach
                    @endif
                </div>
                @if ($comment->replies_count > $maxReplyCount && $isSingleCommentThread)
                    <x-comment.load-more-replies :moreRepliesCount="$comment->replies_count - $maxReplyCount" />
                @elseif($comment->replies_count > $maxReplyCount && !$isSingleCommentThread)
                    <x-comment.continue-thread :url="$comment->showRoute()" :moreRepliesCount="$comment->replies_count - $maxReplyCount" />
                @endif
                @if ($comment->depth > 10)
                    <x-comment.continue-thread :url="$comment->showRoute()" :moreRepliesCount="$comment->replies_count" />
                @endif
            </div>
        </div>
    </div>

</div>
