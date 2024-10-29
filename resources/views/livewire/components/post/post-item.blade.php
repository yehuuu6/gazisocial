<tr class="transition-all duration-200 hover:bg-gray-50">
    <td class="p-4 text-left">
        <div class="flex items-center gap-2">
            <x-link class="hidden md:block" title="{{ $post->user->name }}"
                href="{{ route('users.show', $post->user->username) }}">
                <img class="size-8 md:size-10 rounded-full object-cover" src="{{ $post->user->avatar }}" alt="avatar">
            </x-link>
            <div class="flex flex-col gap-2 md:gap-0">
                <div class="item-center flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" wire:navigate
                            wire:key="post-tag-{{ $tag->id }}"
                            class="{{ $this->getTagColor($tag->color) }} rounded-full px-1.5 py-0.5 text-xs font-medium capitalize text-white transition-all duration-100 hover:bg-opacity-90 md:px-2 md:py-1">{{ $tag->name }}</a>
                    @endforeach
                </div>
                <x-link href="{{ $post->showRoute() }}"
                    class="flex md:items-center gap-2 hover:opacity-85 break-all text-sm font-medium text-gray-700 transition-all duration-300 hover:no-underline md:text-base lg:text-lg">
                    <span>{{ $post->title }}</span>
                    @if ($post->anonToMe())
                        <x-tooltip text="Anonim, sadece ben görebilirim">
                            <span>
                                <x-icons.anon size="22" color="orange" />
                            </span>
                        </x-tooltip>
                    @endif
                </x-link>
            </div>
        </div>
    </td>
    <td class="p-4 text-center text-xs font-semibold text-gray-400 md:text-sm">
        {{ number_format($post->getCommentsCount()) }}
    </td>
    <td class="hidden p-4 text-center text-xs text-gray-400 md:table-cell md:text-sm">
        <x-tooltip text="Popularity = {{ $post->popularity }}">
            <span>{{ Number::abbreviate($post->likes_count) }}</span>
        </x-tooltip>
    </td>
    <td class="hidden p-4 text-center text-xs text-gray-400 md:table-cell md:text-sm">
        {{ $post->created_at->locale('tr')->diffForHumans() }}
    </td>
    <td class="p-4 text-center text-xs text-gray-400 md:hidden md:text-sm">
        {{ $post->created_at->locale('tr')->shortAbsoluteDiffForHumans() }}
    </td>
</tr>
