<div>
    <div class="bg-white rounded-xl shadow-md border border-gray-100">
        <div class="w-full rounded-t-xl flex justify-between gap-4">
            <div class="w-full">
                <div class="flex gap-4 items-center p-6">
                    <div class="size-16 object-contain overflow-hidden rounded-full">
                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full">
                    </div>
                    <div class="flex flex-col">
                        <h6 class="font-semibold text-gray-800 text-lg">
                            {{ $user->name }}
                        </h6>
                        <span class="text-sm text-gray-600">{{ '@' . $user->username }}</span>
                    </div>
                </div>
                <div class="flex items-center flex-wrap font-semibold text-sm gap-5 px-6 py-3">
                    <x-link href="#" class="text-gray-800 rounded-full bg-slate-300 p-2">
                        Overview
                    </x-link>
                    <x-link href="#" class="text-gray-800 rounded-full p-2">
                        Posts
                    </x-link>
                    <x-link href="#" class="text-gray-800 rounded-full p-2">
                        Comments
                    </x-link>
                </div>
            </div>
            <div class="rounded-xl bg-gray-50 w-96 p-4 m-2">
                <div class="flex items-center justify-between gap-2 mb-1">
                    <h4 class="text-gray-900 font-bold">{{ $user->username }}</h4>
                    <button type="button" class="p-1.5 rounded-full bg-gray-200 hover:bg-gray-300">
                        <x-icons.dots size="16" class="text-gray-800" />
                    </button>
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
                        KUPALAR
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
