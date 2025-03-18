@props(['renderBadge' => false])
<div class="relative overflow-hidden rounded-lg border border-gray-200">
    @if ($renderBadge && Auth::user()->isStudent())
        <span title="Öğrencilere özel"
            class="absolute -right-9 top-2 grid w-[120px] rotate-45 place-items-center bg-primary p-1">
            <x-icons.graduate color="white" size="20" />
        </span>
    @endif
    {{ $slot }}
</div>
