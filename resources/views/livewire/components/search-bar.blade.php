@php
    $borderClass = 'rounded-full';
    // If posts has more than 1 post, add border-b
    if (count($posts) >= 1) {
        $borderClass = 'rounded-t-xl';
    }
@endphp

<div class="flex-1 flex gap-2 relative">
    <input type="text" class="p-2 w-full text-black {{ $borderClass }} border border-gray-300 focus:outline-none"
        placeholder="Bir konu ara..." wire:model.live="search">
    <ul class="absolute w-full bg-white rounded-b-lg shadow-lg z-10 top-[2.65rem]">
        @foreach ($posts as $post)
            <li wire:key="{{ $post->id }}">
                <x-posts.search-item :title="$post->title" :avatar="$post->user->avatar" />
            </li>
        @endforeach
    </ul>
</div>
