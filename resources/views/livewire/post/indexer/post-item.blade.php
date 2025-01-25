<tr class="transition-all duration-200 hover:bg-gray-50 cursor-pointer"
    x-on:click="Livewire.navigate('{{ $post->showRoute() }}')">
    <td class="p-4 text-left">
        <div class="flex items-center gap-4">
            <x-link class="hidden md:flex w-10 h-9 shadow rounded-full overflow-hidden" title="{{ $post->user->name }}"
                href="{{ route('users.show', $post->user->username) }}">
                <img class="w-full h-full object-cover" src="{{ $post->user->avatar }}" alt="avatar">
            </x-link>
            <div class="flex flex-col gap-2 md:gap-0 w-full">
                <div class="item-center flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <x-post.post-tag :tag="$tag" :key="'post-tag-' . $tag->id" />
                    @endforeach
                </div>
                <h1 class="flex md:items-center gap-2 w-full break-all text-base font-medium text-gray-700 md:text-lg">
                    <span>{{ $post->title }}</span>
                </h1>
                <div class="md:hidden">
                    <x-link href="{{ route('users.show', $post->user->username) }}"
                        class="text-xs font-normal text-blue-500">
                        <span>{{ $post->user->name }}</span>
                    </x-link>
                    <span class="text-xs font-light text-gray-600"> tarafından</span>
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
