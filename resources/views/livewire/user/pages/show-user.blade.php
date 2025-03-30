@section('ogtags')
    <meta property="og:title" content="{{ $user->name }} - Gazi Social">
    <meta property="og:url" content="{{ route('users.show', $user->username) }}">
    <meta property="og:image" content="{{ $user->getAvatar() }}" itemprop="image">
    <meta property="twitter:title" content="{{ $user->name }} - Gazi Social">
    <meta property="twitter:image" content="{{ $user->getAvatar() }}">
@endsection
<div x-data="{
    activeTab: '{{ $activeTab }}',
    navbarHeight: 0
}" x-on:scroll-to-top.window="window.scrollTo({ top: 0, behavior: 'smooth' })">
    @if ($user->isNewAccount() && !$user->canDoHighLevelAction() && !$user->isStudent())
        <div
            class="mb-4 shadow-sm flex flex-col md:flex-row gap-1 md:gap-2 items-end md:items-center justify-between w-full bg-gradient-to-bl from-lime-50 to-green-100 px-6 py-4 select-none text-lime-700 rounded-xl">
            <div class="inline-flex items-center gap-3">
                <x-icons.info size="18" class="flex-shrink-0" />
                <span class="text-xs lg:text-sm font-medium">
                    Yeni hesap! Bu kullanıcı, Gazi Social'a yeni katıldı ve inceleme sürecinde.
                </span>
            </div>
            <button type="button" disabled
                class="hidden md:flex text-xs lg:text-sm text-transparent bg-transparent px-2 py-1 rounded font-medium">
                holder
            </button>
        </div>
    @endif
    <div class="bg-white rounded-xl shadow-md border border-gray-100">
        <!-- Kullanıcı Bilgileri Başlık - Yapışkan -->
        <div>
            <div
                class="w-full p-4 border-b border-gray-200 bg-white/80 backdrop-blur-md rounded-t-xl transition-all duration-200">
                <div class="flex flex-col sm:flex-row sm:items-start gap-3">
                    <div class="size-24 overflow-hidden rounded-full flex-shrink-0">
                        <img src="{{ asset($user->getAvatar()) }}" alt="{{ $user->name }}"
                            class="w-full object-cover h-full">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <div class="flex flex-col gap-0">
                                    <div class="flex flex-col lg:flex-row flex-wrap lg:items-center gap-2">
                                        <h1 class="text-2xl lg:text-xl font-semibold text-gray-800">
                                            {{ $user->name }}
                                        </h1>
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach ($user->roles()->orderBy('level', 'desc')->orderBy('id', 'desc')->get() as $role)
                                                <span
                                                    class="bg-{{ $role->color }}-500 select-none rounded-full px-2 py-1 md:px-2.5 text-xs font-medium md:font-semibold capitalize text-white">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 mt-1.5 flex-wrap break-all">
                                        <span class="text-sm text-gray-500">{{ '@' . $user->username }}</span>
                                        <span class="text-xs text-gray-500">•</span>
                                        <span class="text-sm text-gray-500">
                                            {{ $user->created_at->locale('tr')->translatedFormat('j F Y') }} tarihinden
                                            beri
                                            üye
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @auth
                                @if (Auth::user()->id === $user->id)
                                    <a href="{{ route('users.edit', $user->username) }}"
                                        class="hidden lg:flex items-center justify-center border border-gray-200 gap-1.5 px-4 py-2 text-xs hover:bg-gray-50 rounded text-gray-800 font-medium w-fit">
                                        <x-icons.edit size="14" />
                                        Profili Düzenle
                                    </a>
                                @endif
                            @endauth
                        </div>

                        <div class="mt-2.5 flex flex-wrap gap-x-3 gap-y-1 text-xs md:text-sm">
                            <div class="flex items-center gap-1">
                                <x-icons.document size="16" />
                                <span class="font-medium text-gray-800">
                                    @if ($this->isOwnProfile())
                                        {{ $user->posts->count() }}
                                    @else
                                        {{ $user->nonAnonymousPosts()->count() }}
                                    @endif
                                    konu
                                </span>
                            </div>
                            <div class="flex items-center gap-1">
                                <x-icons.comment size="16" />
                                <span class="font-medium text-gray-800">
                                    {{ $user->comments->count() }} yorum
                                </span>
                            </div>
                            @if ($user->faculty)
                                <div class="flex items-center gap-1">
                                    <x-icons.graduate size="16" />
                                    <span class="font-medium text-gray-800">
                                        {{ $user->faculty->name }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <p class="text-sm text-gray-800 mt-2.5 lg:w-1/2" style="word-break: break-word;">
                            {{ $user->bio }}
                        </p>

                        @auth
                            @if (Auth::user()->id === $user->id)
                                <a href="{{ route('users.edit', $user->username) }}"
                                    class="mt-5 flex lg:hidden items-center justify-center border border-gray-200 gap-1.5 px-4 py-2 text-xs hover:bg-gray-50 rounded text-gray-800 font-medium w-fit">
                                    <x-icons.edit size="14" />
                                    Profili Düzenle
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            <!-- Sekmeler - Yapışkan -->
            <div
                class="flex-col lg:flex-row px-4 bg-white/80 backdrop-blur-md transition-all duration-200 flex items-center justify-between gap-4 mt-5">
                <div class="flex items-center rounded-md bg-gray-100 p-1 w-full lg:w-auto">
                    <a wire:navigate href="{{ route('users.show', $user->username) }}"
                        :class="{ 'bg-white text-gray-800': activeTab === 'posts', 'text-gray-500 bg-gray-100': activeTab !== 'posts' }"
                        class="px-3 py-1.5 text-sm rounded-md text-center font-semibold w-full lg:w-auto">
                        <span>Konular</span>
                    </a>
                    <a wire:navigate href="{{ route('users.comments', $user->username) }}"
                        :class="{ 'bg-white text-gray-800': activeTab === 'comments', 'text-gray-500 bg-gray-100': activeTab !== 'comments' }"
                        class="px-3 py-1.5 text-sm rounded-md font-semibold w-full lg:w-auto text-center">
                        <span>Yorumlar</span>
                    </a>
                </div>
                <div x-cloak x-show="activeTab === 'posts'"
                    class="flex items-center w-full lg:w-auto gap-2 border border-gray-200 rounded-md p-2 text-sm text-gray-800 font-medium">
                    <input type="text" placeholder="Ara..." spellcheck="false" wire:model="search" autocomplete="off"
                        x-on:keydown.enter="$wire.runSearch" class="bg-transparent focus:outline-none w-full lg:w-52"
                        id="search-in-profile">
                    @if ($search)
                        <button wire:click="clearSearch" class="text-gray-500 hover:text-gray-700">
                            <x-icons.close size="16" />
                        </button>
                    @endif
                    <button wire:click="runSearch" wire:loading.attr="disabled"
                        class="text-primary hover:text-blue-700">
                        <span wire:loading.remove wire:target="runSearch">
                            <x-icons.search size="16" />
                        </span>
                        <span wire:loading.flex wire:target="runSearch">
                            <x-icons.spinner size="16" />
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Gönderiler -->
        <div x-show="activeTab === 'posts'" class="p-4 min-h-96">
            <div class="flex flex-col gap-4">
                @forelse ($this->posts as $post)
                    <div class="rounded-md border border-gray-200 p-4" wire:key="post-{{ $post->id }}">
                        <div>
                            <div class="flex items-start justify-between gap-10">
                                <x-link href="{{ $post->showRoute() }}" style="word-break: break-word;"
                                    class="text-gray-800 font-semibold flex items-center gap-1.5">
                                    @if ($post->isAnonim())
                                        <div class="font-normal">
                                            <span class="text-amber-500">
                                                <x-icons.mask size="24" />
                                            </span>
                                        </div>
                                    @endif
                                    {{ $post->title }}
                                </x-link>
                                @can('delete', $post)
                                    <div x-data="{
                                        openMorePostButtons: false,
                                        confirmDelete: false,
                                    }" class="flex-shrink-0" x-ref="moreButton">
                                        <button x-on:click="openMorePostButtons = true" type="button"
                                            class="p-1 rounded-full hover:bg-gray-100 text-gray-800">
                                            <x-icons.dots size="18" />
                                        </button>
                                        <x-post.post-more-dropdown :$post />
                                    </div>
                                @endcan
                            </div>
                            <div class="flex items-center gap-1.5 mb-2">
                                @foreach ($post->tags as $tag)
                                    <x-post.post-tag :tag="$tag" :key="'tag-' . $tag->id" />
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3.5">
                            <p class="text-sm text-gray-500 mb-1 w-full lg:w-5/6" style="word-break: break-word;">
                                {{ mb_substr(strip_tags($post->html), 0, 200, 'UTF-8') }}...
                            </p>
                        </div>
                        <div class="mt-3.5 flex items-end md:items-center justify-between gap-5">
                            <div class="flex items-center gap-3.5 text-gray-500 flex-wrap">
                                <div class="flex items-center gap-1 text-xs">
                                    <x-icons.calendar size="16" />
                                    <span class="hidden md:inline-block">
                                        {{ $post->created_at->locale('tr')->translatedFormat('d F, Y') }}
                                    </span>
                                    <span class="inline-block md:hidden">
                                        {{ $post->created_at->locale('tr')->translatedFormat('d M, Y') }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1 text-xs">
                                    <x-icons.comment size="16" />
                                    {{ $post->getCommentsCount() }} yorum
                                </div>
                                <div class="flex items-center gap-1 text-xs">
                                    <x-icons.heart size="16" />
                                    {{ $post->likes_count }} beğeni
                                </div>
                            </div>
                            <div class="flex items-center shrink-0">
                                <x-link href="{{ $post->showRoute() }}" class="text-xs text-gray-800">
                                    Devamını oku
                                </x-link>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex items-center justify-center w-full py-16">
                        <h2 class="text-gray-500 font-semibold text-lg">
                            Henüz hiç gönderi yok
                        </h2>
                    </div>
                @else
                    <div class="mt-4">
                        {{ $this->posts->links('livewire.pagination.profile') }}
                    </div>
                @endforelse
            </div>
        </div>

        <div x-show="activeTab === 'comments'" x-cloak class="p-4 min-h-96">
            <div class="flex flex-col gap-4">
                @forelse ($this->comments as $comment)
                    <div class="rounded-md border border-gray-200 p-4" wire:key="comment-{{ $comment->id }}">
                        <div class="flex flex-col lg:gap-2">
                            <!-- Yorum Başlığı -->
                            <div class="flex md:items-center justify-between gap-4">
                                <div>
                                    <x-link
                                        href="{{ $comment->post && $comment->post->exists ? $comment->post->showRoute() : '#' }}"
                                        class="text-xs md:text-sm text-gray-800 font-medium">
                                        <span class="text-gray-600 text-xs md:text-sm font-normal">Şu konuya:</span>
                                        {{ $comment->post ? Str::limit($comment->post->title, 50) : 'Silinmiş konu' }}
                                    </x-link>
                                    <span class="hidden md:block text-gray-500 text-xs">•</span>
                                    <br class="md:hidden">
                                    <span class="text-xs text-gray-500">
                                        {{ $comment->created_at->locale('tr')->translatedFormat('d F Y H:i') }}
                                    </span>
                                </div>
                                @can('delete', $comment)
                                    <div x-data="{ openMoreCommentButtons: false, confirmDelete: false }" x-ref="moreCommentButton">
                                        <button x-on:click="openMoreCommentButtons = true" type="button"
                                            class="p-1 rounded-full hover:bg-gray-100 text-gray-800">
                                            <x-icons.dots size="18" />
                                        </button>
                                        <x-comment.comment-more-dropdown-profile :$comment />
                                    </div>
                                @endcan
                            </div>

                            <!-- Yorum İçeriği -->
                            <div class="text-sm text-gray-800 break-words line-clamp-4 sm:line-clamp-none">
                                @if ($comment->content)
                                    <p class="whitespace-pre-line line-clamp-4" style="word-break: break-words">
                                        {{ Str::limit($comment->content, 500) }}
                                    </p>
                                @endif

                                @if ($comment->gif_url)
                                    <div class="mt-1 lg:mt-2 max-w-[200px] sm:max-w-[275px]">
                                        <img src="{{ $comment->gif_url }}" alt="GIF" class="rounded-lg w-full">
                                    </div>
                                @endif
                            </div>

                            <!-- Yorum Alt Bilgileri -->
                            <div class="flex items-end md:items-center justify-between mt-2">
                                <div class="flex flex-wrap items-center gap-3.5 text-gray-500">
                                    <div class="flex items-center gap-1 text-xs">
                                        <x-icons.heart size="16" />
                                        {{ $comment->likes_count }} beğeni
                                    </div>
                                    <div class="flex items-center gap-1 text-xs">
                                        <x-icons.comment size="16" />
                                        {{ $comment->getAllRepliesCount() }} yanıt
                                    </div>
                                </div>
                                <div class="shrink-0">
                                    @if ($comment->commentable_type === 'comment')
                                        <x-link
                                            href="{{ $comment->commentable && method_exists($comment->commentable, 'showRoute') ? $comment->commentable->showRoute(['reply' => $comment->id]) : '#' }}"
                                            class="text-xs shrink-0 text-gray-800">
                                            Yanıta git
                                        </x-link>
                                    @else
                                        <x-link
                                            href="{{ method_exists($comment, 'showRoute') ? $comment->showRoute() : '#' }}"
                                            class="shrink-0 text-xs text-gray-800">
                                            Yoruma git
                                        </x-link>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex items-center justify-center w-full py-16">
                        <h2 class="text-gray-500 font-semibold text-lg">
                            Henüz hiç yorum yok
                        </h2>
                    </div>
                @else
                    <div class="mt-4">
                        {{ $this->comments->links('livewire.pagination.profile') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
