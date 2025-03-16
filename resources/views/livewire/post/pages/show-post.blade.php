@section('canonical')
    <link rel="canonical" href="{{ $post->showRoute() }}">
@endsection
@push('scripts')
    @vite('resources/js/syntax-highlight.js')
@endpush
<div x-data="{
    userPanel: false,
    isSingleThread: $wire.isSingleCommentThread,
    commentCount: $wire.commentsCount,
    isLiked: $wire.isLiked,
    toggleLike() {
        $wire.toggleLike(); // Call the wire method to toggle the like status behind the scenes
        // If user is authenticated, update the like count and status on the client side
        if ($wire.isAuthenticated) {
            if (!this.isLiked) {
                $wire.likesCount++;
                this.isLiked = true;
            } else {
                $wire.likesCount--;
                this.isLiked = false;
            }
        }
    }
}" x-on:comment-added.window="commentCount++"
    x-on:comment-deleted.window="commentCount -= $event.detail.decreaseCount;">
    <div class="flex flex-col rounded-xl border border-gray-100 bg-white shadow-md">
        <div class="flex relative">
            <button x-on:click="userPanel = !userPanel" x-show="!userPanel"
                class="lg:hidden absolute top-2 right-2 z-10 p-2 bg-white rounded-full shadow-md">
                <x-icons.arrow-left-alt size="24" />
            </button>
            <div class="flex-grow">
                <div class="flex w-full flex-col py-4 px-6 gap-2 md:gap-4 md:px-10 md:py-6">
                    <div>
                        <x-post.post-title>{{ $post->title }}</x-post.post-title>
                        <div>
                            <span class="text-sm text-gray-600 font-light">
                                {{ $post->created_at->locale('tr')->diffForHumans() }} paylaşıldı</span>
                        </div>
                    </div>
                    <article x-data="highlightCode" wire:ignore
                        class="prose prose-sm max-w-none break-words overflow-x-auto sm:prose-sm md:prose-base lg:prose-lg ProseMirror [&_pre]:overflow-x-auto [&_pre]:whitespace-pre-wrap [&_pre]:break-words [&_code]:break-words">
                        {!! $post->html !!}
                    </article>
                    <div class="flex items-center gap-3.5 mt-3" x-data="{ isDisabled: false }">
                        <button x-on:click="toggleLike()" :disabled='isDisabled'
                            x-on:blocked-from-liking.window="isDisabled = true"
                            class="flex items-center gap-1 text-gray-700 group pr-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none">
                            <div :class="{ 'text-pink-400': isLiked }"
                                class="relative group-hover:text-pink-400 flex items-center justify-center group-focus:transform group-focus:scale-105">
                                <div class="group-active:scale-125 transition-transform duration-150">
                                    <template x-if="isLiked">
                                        <x-icons.heart-off size="24" />
                                    </template>
                                    <template x-if="!isLiked">
                                        <x-icons.heart size="24" />
                                    </template>
                                </div>
                                <div
                                    class="rounded-full hidden group-hover:inline-block absolute size-9 bg-pink-400 opacity-20 inset-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                </div>
                            </div>
                            <span :class="{ 'text-pink-400': isLiked }" wire:text="likesCount"
                                class="font-light text-sm ml-0.5 group-hover:text-pink-400">
                            </span>
                        </button>
                        <button :disabled="isSingleThread"
                            x-on:click="$nextTick(() => {
                                $dispatch('toggle-comment-form');
                                setTimeout(() => {
                                    document.getElementById('comment-form').scrollIntoView({ behavior: 'smooth', block: 'center'});
                                }, 100);
                             })"
                            class="flex items-center gap-1 text-gray-700 group pr-2">
                            <div class="relative group-hover:text-blue-400 flex items-center justify-center">
                                <x-icons.comment size="22" />
                                <div
                                    class="rounded-full hidden group-hover:inline-block absolute size-9 bg-blue-300 opacity-20 inset-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                </div>
                            </div>
                            <span x-text="commentCount" class="font-light text-sm ml-0.5 group-hover:text-blue-400">
                            </span>
                        </button>
                        <button class="flex items-center gap-1 text-gray-700 group pr-2"
                            x-on:click="$wire.showShareModal = true">
                            <div class="relative group-hover:text-green-400 flex items-center justify-center">
                                <x-icons.share size="20" />
                                <div
                                    class="rounded-full hidden group-hover:inline-block absolute size-9 bg-green-300 opacity-20 inset-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                </div>
                            </div>
                            <span class="font-light text-sm ml-0.5 group-hover:text-green-400">
                                Paylaş
                            </span>
                        </button>
                    </div>
                </div>
                <x-seperator />
                <div id="comments">
                    @if (!$isSingleCommentThread)
                        <livewire:post.pages.comments-list :$post lazy="on-load" />
                    @else
                        <livewire:post.pages.single-comment-thread :$renderedReplyId :$selectedCommentId :$post
                            lazy="on-load" />
                    @endif
                </div>
            </div>
            <div :class="{
                '-right-full lg:right-0': !userPanel,
                'right-0': userPanel,
            }"
                x-cloak wire:ignore.self x-data="{ navbarHeight: 0 }" x-init="navbarHeight = document.getElementById('navbar').offsetHeight;
                $el.style.top = navbarHeight + 'px';"
                class="fixed lg:sticky bg-white rounded-tr-xl z-20 top-0 h-full min-w-[285px] w-[285px] md:min-w-[300px] md:w-[300px] lg:min-w-[330px] lg:w-[330px] 2xl:min-w-[375px] 2xl:w-[375px] transform transition-all duration-300 border-l border-gray-200">
                <button x-on:click="userPanel = !userPanel" x-cloak x-show="userPanel"
                    class="absolute top-0 right-0 z-10 p-2 text-gray-700 hover:text-gray-500">
                    <x-icons.close size="24" />
                </button>
                <div class="p-4 lg:p-6">
                    <h4 class="text-sm text-gray-700 font-light uppercase mb-2">KULLANICI DETAYLARI</h4>
                    <div class="flex items-center justify-between gap-3 flex-col lg:flex-row">
                        <div class="flex gap-2.5 items-center">
                            <div class="size-10 shrink-0 rounded-full overflow-hidden">
                                <img class="object-cover" src="{{ asset($post->user->avatar) }}" alt="avatar">
                            </div>
                            <div class="flex flex-col">
                                <span class="text-gray-700 font-medium text-sm">{{ $post->user->name }}</span>
                                <span class="text-gray-500 text-xs">{{ '@' . $post->user->username }}</span>
                            </div>
                        </div>
                        <x-link href="{{ route('users.show', $post->user) }}"
                            class="text-white w-full text-center lg:w-fit flex-shrink-0 px-4 py-2 rounded bg-primary transition duration-300 hover:bg-opacity-90 hover:no-underline text-xs font-medium">
                            Profili Gör
                        </x-link>
                    </div>
                    <p class="text-sm mt-4 text-gray-600">{{ $post->user->bio }}</p>
                    <div class="mt-2 space-y-1.5">
                        @if ($post->user->faculty)
                            <div class="flex items-center gap-1.5 text-gray-500 font-light">
                                <x-icons.graduate size="18" />
                                <span class="text-xs text-gray-700">{{ $post->user->faculty->name }}</span>
                            </div>
                        @endif
                        <div class="flex items-center gap-1.5 text-gray-500 font-light">
                            <x-icons.cake size="18" />
                            <span
                                class="text-xs text-gray-700">{{ $post->user->created_at->locale('tr')->diffForHumans() }}
                                Gazi Social'a katıldı</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-gray-500 font-light">
                            <x-icons.activity size="18" />
                            <span class="text-xs text-gray-700">
                                Son aktivite {{ $post->user->last_activity->locale('tr')->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
                <x-seperator />
                <div class="p-4 lg:p-6">
                    <h4 class="text-sm text-gray-700 font-light uppercase">KULLANICI ROZETLERİ</h4>
                    <div class="flex items-center flex-wrap gap-1 mt-2">
                        @foreach ($post->user->roles as $role)
                            <span
                                class="{{ $colorVariants[$role->color] }} cursor-default rounded-full px-2 py-1 text-xs font-medium capitalize text-white">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </div>
                <x-seperator />
                <div class="p-4 lg:p-6">
                    <h4 class="text-sm text-gray-700 font-light uppercase mb-1">GÖNDERİ ETİKETLERİ</h4>
                    <div class="flex flex-wrap items-center gap-1.5 mt-2">
                        @foreach ($post->tags as $tag)
                            <x-post.post-tag :tag="$tag" :key="'tag-' . $tag->id" />
                        @endforeach
                    </div>
                </div>
                <x-seperator />
                <div class="p-4 lg:p-6">
                    <h4 class="text-sm text-gray-700 font-light uppercase">EKLENEN ANKETLER</h4>
                    <div class="mt-2 flex items-center flex-wrap gap-2">
                        @forelse ($this->polls as $poll)
                            <button wire:key="poll-button-{{ $poll->id }}" type="button"
                                x-on:click="$dispatch('load-poll-data', { pollId: {{ $poll->id }} }); $wire.showPollModal = true;"
                                class="text-sm text-white font-medium py-1 px-2 bg-green-500 rounded">
                                {{ $poll->question }}
                            </button>
                        @empty
                            <p class="text-gray-600 font-light text-sm">Bu gönderiye ait anket bulunmamaktadır.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:poll.show-poll-modal :$post />
    <x-post.share-modal :url="$post->showRoute()" />
</div>
