@props(['user', 'size' => 24, 'iconSize' => 30])
@php
    $sizeClass = 'size-' . $size;
@endphp
<div class="relative flex items-center group justify-center rounded-full overflow-hidden">
    @auth
        @if (Auth::user()->id === $user->id)
            <div title="Profil resmini değiştir" @click="updateAvatarModal = true"
                class="absolute size-full hidden group-hover:grid place-items-center bg-black bg-opacity-50 cursor-pointer">
                <div id="update-avatar-item">
                    <x-icons.image size='{{ $iconSize }}' color='#f2f2f2' />
                </div>
            </div>
        @endif
    @endauth
    <img src="{{ $user->avatar }}" alt="profil resmi" class="object-cover {{ $sizeClass }}">
</div>
