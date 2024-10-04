@props(['user', 'size' => 24, 'iconSize' => 30])
@php
    $sizeClass = 'size-' . $size;
@endphp
<div class="relative flex items-center group justify-center rounded-full overflow-hidden">
    @auth
        @if (Auth::user()->id === $user->id)
            <div title="Profil resmini değiştir" @click="updateAvatarModal = true"
                class="absolute size-full z-0 hidden group-hover:grid place-items-center bg-black bg-opacity-50 cursor-pointer">
                <x-icons.image size='{{ $iconSize }}' color='#f2f2f2' />
            </div>
        @endif
    @endauth
    <img src="{{ $user->avatar }}" alt="profil resmi" class="object-cover {{ $sizeClass }}">
</div>
