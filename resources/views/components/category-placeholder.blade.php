@php
    $widthOptions = ['w-1/2', 'w-1/3', 'w-1/4'];
@endphp
<x-scrollable-wrapper class="h-full animate-pulse">
    <div class="flex items-center w-full mt-2 mb-5 mx-4 gap-3">
        <div class="rounded bg-slate-200 h-5 w-10"></div>
        <div class="h-2 bg-slate-200 rounded {{ $widthOptions[array_rand($widthOptions)] }}"></div>
    </div>
    <div class="flex items-center w-full mt-5 mb-5 mx-4 gap-3">
        <div class="rounded bg-slate-200 h-5 w-10"></div>
        <div class="h-2 bg-slate-200 rounded {{ $widthOptions[array_rand($widthOptions)] }}"></div>
    </div>
    <div class="flex items-center w-full mt-5 mb-5 mx-4 gap-3">
        <div class="rounded bg-slate-200 h-5 w-10"></div>
        <div class="h-2 bg-slate-200 rounded {{ $widthOptions[array_rand($widthOptions)] }}"></div>
    </div>
    <div class="flex items-center w-full mt-5 mb-5 mx-4 gap-3">
        <div class="rounded bg-slate-200 h-5 w-10"></div>
        <div class="h-2 bg-slate-200 rounded {{ $widthOptions[array_rand($widthOptions)] }}"></div>
    </div>
    <div class="flex items-center w-full mt-5 mb-5 mx-4 gap-3">
        <div class="rounded bg-slate-200 h-5 w-10"></div>
        <div class="h-2 bg-slate-200 rounded {{ $widthOptions[array_rand($widthOptions)] }}"></div>
    </div>
    <div class="flex items-center w-full mt-5 mb-5 mx-4 gap-3">
        <div class="rounded bg-slate-200 h-5 w-10"></div>
        <div class="h-2 bg-slate-200 rounded {{ $widthOptions[array_rand($widthOptions)] }}"></div>
    </div>
    <div class="flex items-center w-full mt-5 mb-5 mx-4 gap-3">
        <div class="rounded bg-slate-200 h-5 w-10"></div>
        <div class="h-2 bg-slate-200 rounded {{ $widthOptions[array_rand($widthOptions)] }}"></div>
    </div>
    <div class="flex items-center w-full mt-5 mb-5 mx-4 gap-3">
        <div class="rounded bg-slate-200 h-5 w-10"></div>
        <div class="h-2 bg-slate-200 rounded {{ $widthOptions[array_rand($widthOptions)] }}"></div>
    </div>
    <div class="flex items-center w-full mt-5 mb-5 mx-4 gap-3">
        <div class="rounded bg-slate-200 h-5 w-10"></div>
        <div class="h-2 bg-slate-200 rounded {{ $widthOptions[array_rand($widthOptions)] }}"></div>
    </div>
    <div class="flex items-center w-full mt-5 mb-2 mx-4 gap-3">
        <div class="rounded bg-slate-200 h-5 w-10"></div>
        <div class="h-2 bg-slate-200 rounded {{ $widthOptions[array_rand($widthOptions)] }}"></div>
    </div>
</x-scrollable-wrapper>
