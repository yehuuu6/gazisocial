<x-link href="{{ route('tags.show', $tag->slug) }}"
    class="bg-{{ $tag->color }}-500 self-start select-none rounded-full px-2 py-1 md:px-2.5 text-xs font-medium md:font-semibold capitalize text-white transition-all duration-100 hover:bg-opacity-90 hover:no-underline">
    {{ $tag->name }}
</x-link>
