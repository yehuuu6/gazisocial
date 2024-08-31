@php
    $bio = $user->bio ?? 'Herhangi bir bilgi verilmemiş.';
    // Color variants
    $colorVariants = [
        'blue' => 'bg-blue-700',
        'red' => 'bg-red-700',
        'green' => 'bg-green-700',
    ];
@endphp
<div class="flex gap-3 p-4">
    <img class="rounded-full size-14" src="{{ asset($user->avatar) }}" alt="profile picture">
    <div class="flex flex-col gap-3 flex-1">
        <div class="flex items-center justify-between">
            <div class="flex gap-1 items-end">
                <h1 class="text-xl font-medium">{{ $user->name }}</h1>
                <div class="flex items-center gap-2">
                    <span class="text-gray-600 text-sm">{{ '@' . $user->username }}</span>
                    @forelse ($user->roles as $role)
                        <span
                            class="py-1 px-2 {{ $colorVariants[$role->color] }} text-white font-medium rounded capitalize text-xs">{{ $role->name }}</span>
                    @empty
                        <span
                            class="py-1 px-2 bg-gray-700 text-white font-medium rounded-full capitalize text-xs">Üye</span>
                    @endforelse
                </div>
            </div>
            <x-icons.settings color="#4b5563" size="30" />
        </div>
        <p class="text-gray-600">{{ $bio }}</p>
        <div class="flex gap-3 items-center">
            <div class="flex gap-1 items-center">
                <x-icons.graduate color="#4b5563" size="28" />
                <span class="text-gray-600">{{ $user->faculty ?? 'Hemşirelik Fakültesi' }}</span>
            </div>
            <div class="flex items-center gap-1">
                <x-icons.trophy color="#4b5563" size="30" /><span class="text-gray-600">Seviye 10</span>
            </div>

            <div class="flex items-center gap-1">
                <x-icons.post color="#4b5563" size="25" />
                <span class="text-gray-600">{{ $user->posts->count() }} Gönderi</span>
            </div>
            <div class="flex items-center gap-1">
                <x-icons.comment-count color="#4b5563" size="26" />
                <span class="text-gray-600">{{ $user->comments->count() }} Yorum</span>
            </div>
            <div class="flex gap-1 items-center">
                <x-icons.calender color="#4b5563" size="28" />
                <span class="text-gray-600">{{ $user->created_at->translatedFormat('F Y') }}
                    tarihinden beri</span>
            </div>
        </div>
    </div>
</div>
