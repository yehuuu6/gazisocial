@section('canonical')
    <link rel="canonical" href="{{ $post->showRoute() }}">
@endsection
@push('scripts')
    @vite('resources/js/syntax-highlight.js')
@endpush
<div x-data="{
    shareModal: false,
    isSingleThread: $wire.isSingleCommentThread,
    commentForm: false,
    commentCount: $wire.commentsCount,
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
}" x-on:comment-added.window="commentCount++"
    x-on:comment-deleted.window="commentCount -= $event.detail.decreaseCount;">
    <div class="flex flex-col rounded-xl border border-gray-100 bg-white shadow-md">
        <div class="md:flex">
            <div class="flex-grow">
                <div class="flex w-full flex-col py-4 px-6 gap-2 md:gap-4 md:px-10 md:py-6">
                    <div>
                        <x-post.post-title>{{ $post->title }}</x-post.post-title>
                        <div>
                            <span class="text-sm text-gray-600 font-light">
                                {{ $post->created_at->locale('tr')->diffForHumans() }} paylaşıldı</span>
                        </div>
                    </div>
                    <article x-data="highlightCode"
                        class="prose prose-sm max-w-none break-all sm:prose-sm md:prose-base lg:prose-xl ProseMirror">
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
                            <span :class="{ 'text-pink-400': isLiked }" x-text="likeCount"
                                class="font-light text-sm ml-0.5 group-hover:text-pink-400">
                            </span>
                        </button>
                        <button :disabled="isSingleThread"
                            x-on:click="$nextTick(() => {
                                commentForm = true;
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
                        <button class="flex items-center gap-1 text-gray-700 group pr-2" x-on:click="shareModal = true">
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
                        <livewire:post.pages.single-comment-thread :$selectedCommentId :$post lazy="on-load" />
                    @endif
                </div>
            </div>
            <div
                class="hidden rounded-br-xl rounded-tr-xl relative md:inline-block md:min-w-[200px] md:w-[200px] lg:min-w-[375px] lg:w-[375px] bg-white border-l border-gray-200">
                <div wire:ignore.self class="sticky" x-data="{ navbarHeight: 0 }" x-init="navbarHeight = document.getElementById('navbar').offsetHeight;
                $el.style.top = navbarHeight + 'px';">
                    <div class="p-6">
                        <h4 class="text-sm text-gray-700 font-light uppercase mb-2">KULLANICI DETAYLARI</h4>
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex gap-2.5 items-center">
                                <div class="size-10 rounded-full overflow-hidden">
                                    <img class="object-cover" src="{{ asset($post->user->avatar) }}" alt="avatar">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-gray-700 font-medium text-sm">{{ $post->user->name }}</span>
                                    <span class="text-gray-500 text-xs">{{ '@' . $post->user->username }}</span>
                                </div>
                            </div>
                            <div>
                                <x-link href="{{ route('users.show', $post->user) }}"
                                    class="text-white px-4 py-2 rounded bg-blue-500 hover:bg-blue-600 hover:no-underline text-xs font-medium">
                                    Profili Gör
                                </x-link>
                            </div>
                        </div>
                        <p class="text-sm mt-4 text-gray-600">{{ $userBio }}</p>
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
                    <div class="p-6">
                        <h4 class="text-sm text-gray-700 font-light uppercase">KULLANICI ROZETLERİ</h4>
                        <div class="flex items-center flex-wrap gap-1 mt-2 mb-3">
                            @foreach ($post->user->roles as $role)
                                <span
                                    class="{{ $colorVariants[$role->color] }} cursor-default rounded-full px-2 py-1 text-xs font-medium capitalize text-white">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <x-seperator />
                    <div class="p-6">
                        <h4 class="text-sm text-gray-700 font-light uppercase mb-1">GÖNDERİ ETİKETLERİ</h4>
                        <div class="flex flex-wrap items-center gap-1.5 mt-2">
                            @foreach ($post->tags as $tag)
                                <x-post.post-tag :tag="$tag" :key="'tag-' . $tag->id" />
                            @endforeach
                        </div>
                    </div>
                    <x-seperator />
                    <div class="p-6">
                        <h4 class="text-sm text-gray-700 font-light uppercase">EKLENEN ANKETLER</h4>
                        <div class="mt-2">
                            <p class="text-gray-600 font-light text-sm">Bu gönderiye ait anket bulunmamaktadır.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-post.share-modal :url="$post->showRoute()" />
</div>
