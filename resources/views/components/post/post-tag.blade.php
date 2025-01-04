<a wire:navigate href="{{ route('tags.show', $tag->slug) }}"
    class="bg-{{ $tag->color }}-500 rounded-full px-2.5 py-1 text-xs font-medium capitalize text-white transition-all duration-100 hover:bg-opacity-90 hover:no-underline">{{ $tag->name }}</a>
