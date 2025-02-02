<div>
    <div class="bg-white rounded-xl shadow-md border border-gray-100">
        <div class="w-full relative rounded-t-xl flex justify-between gap-4">
            <div class="w-full">
                <div class="flex gap-4 items-center p-6">
                    <div class="size-16 overflow-hidden rounded-full">
                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-full object-cover h-full">
                    </div>
                    <div class="flex flex-col">
                        <h6 class="font-semibold text-gray-800 text-lg">
                            {{ $user->name }}
                        </h6>
                        <span class="text-sm text-gray-600">{{ '@' . $user->username }}</span>
                    </div>
                </div>
                <div class="flex items-center flex-wrap font-semibold text-sm gap-5 px-6 py-3">
                    <x-link href="#" class="text-gray-800 rounded-full bg-slate-300 py-2 px-3">
                        Konular
                    </x-link>
                    <x-link href="#" class="text-gray-800 rounded-full py-2 px-3">
                        Yorumlar & Yanıtlar
                    </x-link>
                    <x-link href="#" class="text-gray-800 rounded-full py-2 px-3">
                        Beğenilenler
                    </x-link>
                </div>
                <div class="px-6 py-3 flex flex-col gap-2 h-full">
                    @forelse ($this->posts as $post)
                        <div class="rounded-xl bg-gray-50 border border-gray-100 p-4">
                            <div>
                                <div class="flex items-center justify-between gap-10">
                                    <x-link href="{{ $post->showRoute() }}"
                                        class="text-gray-900 font-bold">{{ $post->title }}</x-link>
                                    <div>
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
                                <p class="text-sm text-gray-500 mb-1">
                                    {{ mb_substr(strip_tags($post->html), 0, 200, 'UTF-8') }}...
                                </p>
                            </div>
                            <div class="mt-3.5 flex items-center justify-between gap-5">
                                <div class="flex items-center gap-3.5">
                                    <button type="button"
                                        class="flex items-center gap-1 text-gray-500 hover:text-primary transition duration-300">
                                        <x-icons.heart size="24" />
                                        <span class="text-sm font-medium">
                                            {{ $post->likes->count() }}
                                        </span>
                                    </button>
                                    <button type="button"
                                        class="flex items-center gap-1 text-gray-500 hover:text-primary transition duration-300">
                                        <x-icons.comment size="24" />
                                        <span class="text-sm font-medium">
                                            {{ $post->comments->count() }}
                                        </span>
                                    </button>
                                </div>
                                <div class="flex items-center">
                                    <x-link href="{{ $post->showRoute() }}" class="text-xs text-blue-500">
                                        Devamını oku
                                    </x-link>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center justify-center w-full h-96">
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
            <div class="rounded-xl h-fit sticky bg-gray-50 w-96 p-4 m-2" wire:ignore.self x-data="{ navbarHeight: 0 }"
                x-init="navbarHeight = document.getElementById('navbar').offsetHeight;
                $el.style.top = navbarHeight + 'px';">
                <div class="flex items-center justify-between gap-2 mb-1">
                    <h4 class="text-gray-900 font-bold">{{ $user->username }}</h4>
                    @auth
                        @if (Auth::user()->id === $user->id)
                            <x-link href="{{ route('users.edit', $user->username) }}"
                                class="p-1.5 rounded-full bg-gray-200 hover:opacity-80">
                                <x-icons.cog size="16" class="text-gray-800" />
                            </x-link>
                        @endif
                    @endauth
                </div>
                <button type="button"
                    class="w-full mb-3.5 hover:bg-opacity-90 transition duration-300 text-xs mt-2 p-2 rounded bg-primary text-white font-semibold">
                    Arkadaşlık İsteği Gönder
                </button>
                <div class="mb-3.5">
                    <p class="text-sm text-gray-500 mb-1">
                        {{ $user->bio }}
                    </p>
                    <x-seperator />
                </div>
                <div class="my-3.5 flex items-center justify-between gap-5">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-800 text-sm">
                            {{ $user->posts->count() }}
                        </span>
                        <span class="text-xs text-gray-500">
                            Gönderi
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-800 text-sm">
                            {{ $user->comments->count() }}
                        </span>
                        <span class="text-xs text-gray-500">
                            Yorum
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-800 text-sm">15</span>
                        <span class="text-xs text-gray-500">
                            Arkadaş
                        </span>
                    </div>
                </div>
                <div class="my-3.5 space-y-1">
                    @if ($user->faculty)
                        <div class="flex items-center gap-2 text-gray-500">
                            <x-icons.graduate size="16" />
                            <span class="text-xs font-medium">
                                {{ $user->faculty->name }}
                            </span>
                        </div>
                    @endif
                    <div class="flex items-center gap-2 text-gray-500">
                        <x-icons.activity size="16" />
                        <span class="text-xs font-medium">
                            Son aktivite {{ $user->last_activity->diffForHumans() }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-500">
                        <x-icons.cake size="16" />
                        <span class="text-xs font-medium">
                            {{ $user->created_at->diffForHumans() }} Katıldı
                        </span>
                    </div>
                </div>
                <x-seperator />
                <div class="my-3.5">
                    <h2 class="text-gray-600 font-semibold text-xs mb-2.5">
                        ROZETLER
                    </h2>
                    <div class="flex items-center gap-2 flex-wrap mb-2">
                        @foreach ($user->roles as $role)
                            <span
                                class="{{ $colorVariants[$role->color] }} cursor-default rounded-full px-2 py-1 text-xs font-medium capitalize text-white">{{ $role->name }}</span>
                        @endforeach
                    </div>
                    <x-link href="#" class="text-blue-600 text-xs font-medium">
                        Nasıl Rozet Kazanırım?
                    </x-link>
                </div>
                <x-seperator />
                <div class="my-3.5">
                    <h2 class="text-gray-600 font-semibold text-xs mb-2.5">
                        ÖDÜLLER
                    </h2>
                    <div class="flex items-center gap-2 flex-wrap mb-2">
                        <h3 class="text-xs font-medium text-gray-500">
                            YAKINDA...
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
