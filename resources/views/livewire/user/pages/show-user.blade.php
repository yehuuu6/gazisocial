<div x-data="{
    activeTab: 'posts',
    navbarHeight: 0
}" x-init="navbarHeight = document.getElementById('navbar').offsetHeight;">
    <div class="bg-white rounded-xl shadow-md border border-gray-100 relative">
        <!-- Kullanıcı Bilgileri Başlık - Yapışkan -->
        <div class="sticky top-0 z-10" :style="{ top: navbarHeight + 'px' }">
            <div class="w-full p-4 border-b border-gray-100 bg-white rounded-t-xl">
                <div class="flex flex-col sm:flex-row sm:items-start gap-3">
                    <div class="hidden sm:block size-16 overflow-hidden rounded-full flex-shrink-0">
                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-full object-cover h-full">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <div class="sm:hidden size-10 overflow-hidden rounded-full flex-shrink-0">
                                    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}"
                                        class="w-full object-cover h-full">
                                </div>
                                <div class="flex flex-col gap-0">
                                    <span class="font-bold text-gray-800 text-base lg:text-lg">
                                        {{ $user->name }}
                                    </span>
                                    <span class="text-sm text-gray-600">{{ '@' . $user->username }}</span>
                                </div>
                            </div>
                            @auth
                                @if (Auth::user()->id === $user->id)
                                    <a href="{{ route('users.edit', $user->username) }}"
                                        class="flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs bg-gray-100 hover:bg-gray-200 rounded-md text-gray-700 font-medium w-fit">
                                        <x-icons.edit size="14" />
                                        <span class="hidden sm:inline">Profili Düzenle</span>
                                        <span class="sm:hidden">Düzenle</span>
                                    </a>
                                @endif
                            @endauth
                        </div>

                        <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $user->bio }}</p>

                        <div class="mt-2 flex flex-wrap gap-1.5">
                            @foreach ($user->roles as $role)
                                <span
                                    class="{{ $colorVariants[$role->color] }} select-none rounded-full px-2 py-1 md:px-2.5 text-xs font-medium md:font-semibold capitalize text-white">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>

                        <div class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-xs">
                            <div class="flex items-center gap-1">
                                <span class="font-bold text-gray-800">
                                    @if ($this->isOwnProfile())
                                        {{ $user->posts->count() }}
                                    @else
                                        {{ $user->nonAnonymousPosts()->count() }}
                                    @endif
                                </span>
                                <span class="text-gray-500">
                                    Gönderi
                                </span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="font-bold text-gray-800">
                                    {{ $user->comments->count() }}
                                </span>
                                <span class="text-gray-500">
                                    Yorum
                                </span>
                            </div>
                        </div>

                        <div class="mt-1.5 flex flex-wrap gap-x-3 gap-y-1 text-xs">
                            @if ($user->faculty)
                                <div class="flex items-center gap-1 text-gray-500">
                                    <x-icons.graduate size="12" />
                                    <span>{{ $user->faculty->name }}</span>
                                </div>
                            @endif
                            <div class="flex items-center gap-1 text-gray-500">
                                <x-icons.cake size="12" />
                                <span>{{ $user->created_at->locale('tr')->diffForHumans() }} katıldı</span>
                            </div>
                            <div class="flex items-center gap-1 text-gray-500">
                                <x-icons.activity size="12" />
                                <span>Son: {{ $user->last_activity->locale('tr')->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sekmeler - Yapışkan -->
            <div class="grid grid-cols-2 border-b border-gray-100 bg-white shadow-sm">
                <button x-on:click="activeTab = 'posts'; window.scrollTo({ top: 0, behavior: 'smooth' });"
                    :class="{ 'border-b-2 border-primary text-primary font-medium': activeTab === 'posts', 'text-gray-500 font-normal': activeTab !== 'posts' }"
                    class="py-2.5 text-sm transition-colors duration-200 text-center flex items-center justify-center gap-1.5">
                    <x-icons.document size="16" class="hidden sm:block" />
                    <span>Gönderiler</span>
                </button>
                <button x-on:click="activeTab = 'comments'; window.scrollTo({ top: 0, behavior: 'smooth' });"
                    :class="{ 'border-b-2 border-primary text-primary font-medium': activeTab === 'comments', 'text-gray-500 font-normal': activeTab !== 'comments' }"
                    class="py-2.5 text-sm transition-colors duration-200 text-center flex items-center justify-center gap-1.5">
                    <x-icons.comment size="16" class="hidden sm:block" />
                    <span>Yorumlar</span>
                </button>
            </div>
        </div>

        <!-- Gönderiler -->
        <div x-show="activeTab === 'posts'" class="p-4">
            <div class="flex flex-col gap-4">
                @forelse ($this->posts as $post)
                    <div class="rounded-xl bg-gray-50 border border-gray-100 p-4">
                        <div>
                            <div class="flex items-start justify-between gap-10">
                                <x-link href="{{ $post->showRoute() }}"
                                    class="text-gray-900 break-all font-bold flex items-center gap-1.5">
                                    @if ($post->isAnonim())
                                        <div class="font-normal">
                                            <x-ui.tooltip text="Anonim Gönderi">
                                                <span class="text-amber-500">
                                                    <x-icons.mask size="24" />
                                                </span>
                                            </x-ui.tooltip>
                                        </div>
                                    @endif
                                    {{ $post->title }}
                                </x-link>
                                <div class="flex-shrink-0">
                                    <span class="text-xs text-gray-500">
                                        {{ $post->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 mt-1.5 mb-2">
                                @foreach ($post->tags as $tag)
                                    <x-post.post-tag :tag="$tag" />
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3.5">
                            <p class="text-sm text-gray-500 mb-1 break-all">
                                {{ mb_substr(strip_tags($post->html), 0, 200, 'UTF-8') }}...
                            </p>
                        </div>
                        <div class="mt-3.5 flex items-center justify-between gap-5">
                            <div class="flex items-center gap-3.5">
                                <div class="flex items-center gap-1 text-pink-400">
                                    <x-icons.heart-off size="20" />
                                    <span class="text-sm font-medium">
                                        {{ $post->likes_count }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1 text-blue-400">
                                    <x-icons.comment size="20" />
                                    <span class="text-sm font-medium">
                                        {{ $post->getCommentsCount() }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <x-link href="{{ $post->showRoute() }}" class="text-xs text-blue-500">
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

        <div x-show="activeTab === 'comments'" x-cloak class="p-4">
            <div class="flex items-center justify-center w-full py-16">
                <h2 class="text-gray-500 font-semibold text-lg">
                    Yorumlar yakında eklenecek...
                </h2>
            </div>
        </div>
    </div>
</div>
