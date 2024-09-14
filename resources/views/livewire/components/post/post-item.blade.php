<div class="flex flex-col gap-2 p-2 md:p-4">
    <div class="flex gap-2 items-center">
        <x-link title="{{ $post->user->name }}" href="/u/{{ $post->user->username }}">
            <img class="size-7 md:size-14 rounded-full" src="{{ $post->user->avatar }}" alt="avatar">
        </x-link>
        <div class="flex flex-col-reverse justify-center gap-0">
            <x-link href="{{ $post->showRoute() }}"
                class="item-center sm:text-base md:text-lg lg:text-xl font-medium text-blue-700">
                {{ $post->title }}
            </x-link>
            <div class="flex item-center gap-2">
                @foreach ($post->tags as $tag)
                    <a href="{{ route('category.show', $tag->name) }}" wire:navigate wire:key="tag-{{ $tag->id }}"
                        class="py-1 px-2 {{ $this->getRandomColorForTag() }} text-white transition-all duration-100 font-medium rounded-full capitalize text-xs hover:bg-opacity-90">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <span class="text-gray-500 sm:text-xs md:text-sm lg:text-base">
        {{ $post->created_at->locale('tr')->diffForHumans() }} paylaşıldı.
    </span>
    <div class="post-icon flex ml-2">
        <div class="flex gap-1 items-center">
            <x-icons.comment color="#4b5563" />
            <p class="text-gray-600 font-light text-xs md:text-sm">{{ $post->comments_count }}</p>
        </div>
        <div class="flex gap-1 items-center">
            <x-icons.heart color="#4b5563" />
            <p class="text-gray-600 font-light text-xs md:text-sm">{{ $post->comments_count }}</p>
        </div>
        <div class="flex gap-1 items-center">
            <x-icons.share color="#4b5563" />
            <p class="text-gray-600 font-light text-xs md:text-sm">{{ $post->comments_count }}</p>
        </div>
    </div>
</div>
