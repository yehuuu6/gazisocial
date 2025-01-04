@props(['more_replies_count'])
<div class="relative mt-2.5 w-fit" x-cloak x-show="showReplies">
    <div class="absolute -top-3.5 left-4 border-b border-l rounded-bl-xl size-6 border-gray-200">
    </div>
    <div class="ml-10">
        <a class="flex items-center gap-2 text-xs text-gray-700 hover:underline" href="#">
            <x-icons.continue size="18" />
            <span>{{ $more_replies_count }} cevap daha</span>
        </a>
    </div>
</div>
