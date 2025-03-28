<tr class="transition-all duration-200 hover:bg-gray-50 cursor-pointer"
    x-on:click="Livewire.navigate('{{ $post->showRoute() }}')">
    <td class="p-4 text-left">
        <div class="flex items-center gap-4">
            @if ($post->isAnonim())
                <div class="hidden md:flex w-10 h-9 shadow rounded-full overflow-hidden">
                    <div class="w-full h-full bg-gray-300 grid place-items-center">
                        <x-icons.user size="24" class="text-gray-500" />
                    </div>
                </div>
            @else
                <x-link class="hidden md:flex w-10 h-9 shadow rounded-full overflow-hidden"
                    title="{{ $post->user->name }}" href="{{ route('users.show', $post->user->username) }}">
                    <img class="w-full h-full object-cover" src="{{ $post->user->getAvatar() }}" alt="avatar">
                </x-link>
            @endif
            <div class="flex flex-col gap-2 md:gap-0 w-full">
                <div class="item-center flex flex-wrap gap-2">
                    @if (!$post->is_published)
                        <div class="hidden md:inline-block">
                            <x-ui.tooltip text="Yayınlanmamış">
                                <x-icons.warning size="20" class="text-amber-500 inline-block items-center" />
                            </x-ui.tooltip>
                        </div>
                    @endif
                    @if ($post->is_pinned && $show_pins)
                        <div class="hidden md:inline-block">
                            <x-ui.tooltip text="Sabitlenmiş">
                                <x-icons.pin size="20" class="text-blue-500 inline-block items-center" />
                            </x-ui.tooltip>
                        </div>
                    @endif
                    @foreach ($post->tags as $tag)
                        <x-post.post-tag :tag="$tag" :key="'post-tag-' . $tag->id" />
                    @endforeach
                </div>
                <p style="word-break: break-word;"
                    class="flex md:items-center gap-2 w-full text-base font-medium text-gray-700 md:text-lg">
                    {{ $post->title }}
                </p>
                <div class="md:hidden">
                    @if ($post->isAnonim())
                        <span class="text-xs font-normal text-gray-500">Anonim</span>
                    @else
                        <x-link href="{{ route('users.show', $post->user->username) }}"
                            class="text-xs font-normal text-blue-500">
                            <span>{{ $post->user->name }}</span>
                        </x-link>
                    @endif
                    <span class="text-xs font-light text-gray-600"> tarafından</span>
                    @if (!$post->is_published)
                        <x-icons.warning size="18"
                            class="text-amber-500 ml-1 md:hidden inline-block items-center" />
                    @endif
                    @if ($post->is_pinned && $show_pins)
                        <x-icons.pin size="18" class="text-blue-500 ml-1 md:hidden inline-block items-center" />
                    @endif
                </div>
            </div>
        </div>
    </td>
    <td class="p-4 text-center text-xs font-semibold text-gray-400 md:text-sm">
        <span>{{ Number::abbreviate($post->getCommentsCount()) }}</span>
    </td>
    <td class="hidden p-4 text-center text-xs text-gray-400 md:table-cell md:text-sm">
        <span>{{ Number::abbreviate($post->likes_count) }}</span>
    </td>
    <td class="hidden p-4 text-center text-xs text-gray-400 md:table-cell md:text-sm">
        {{ $post->created_at->locale('tr')->diffForHumans() }}
    </td>
    <td class="p-4 text-center text-xs text-gray-400 md:hidden md:text-sm">
        {{ $post->created_at->locale('tr')->shortAbsoluteDiffForHumans() }}
    </td>
</tr>
