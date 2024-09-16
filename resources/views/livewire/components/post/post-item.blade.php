<tr>
    <td class="p-4 text-left">
        <div class="flex items-center gap-2">
            <x-link class="hidden md:block" title="{{ $post->user->name }}" href="/u/{{ $post->user->username }}">
                <img class="size-8 md:size-10 rounded-full" src="{{ $post->user->avatar }}" alt="avatar">
            </x-link>
            <div class="flex flex-col gap-2 md:gap-1">
                <div class="flex flex-wrap item-center gap-2">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('category.show', $tag->name) }}" wire:navigate
                            wire:key="tag-{{ $tag->id }}"
                            class="py-0.5 px-1.5 md:py-1 md:px-2 {{ $this->getRandomColorForTag() }} text-white transition-all duration-100 font-medium rounded-full capitalize text-xs hover:bg-opacity-90">{{ $tag->name }}</a>
                    @endforeach
                </div>
                <x-link href="{{ $post->showRoute() }}"
                    class="text-sm md:text-base lg:text-lg hover:no-underline text-gray-700 font-medium hover:opacity-85 transition-all duration-300">
                    {{ $post->title }}
                </x-link>
            </div>
        </div>
    </td>
    <td class="p-4 text-center text-xs md:text-sm font-semibold text-gray-400">
        {{ number_format($post->comments_count) }}
    </td>
    <td class="p-4 hidden md:table-cell text-center text-xs md:text-sm text-gray-400">
        {{ number_format(rand(0, 5000)) }}
    </td>
    <td class="p-4 hidden md:table-cell text-center text-xs md:text-sm text-gray-400">
        {{ $post->created_at->locale('tr')->diffForHumans() }}
    </td>
    <td class="p-4 md:hidden text-center text-xs md:text-sm text-gray-400">
        {{ $post->created_at->locale('tr')->shortAbsoluteDiffForHumans() }}
    </td>
</tr>
