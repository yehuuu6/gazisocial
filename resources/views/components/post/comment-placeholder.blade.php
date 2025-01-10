<div class="relative animate-pulse rounded-md w-full my-3">
    <div class="absolute top-1 left-4 h-[95%] border-l border-slate-200 w-2">
    </div>
    <div class="flex items-center gap-2.5 w-full">
        <div class="relative">
            <div class="rounded-full bg-slate-200 size-8"></div>
            @if ($type == 'reply')
                <div
                    class="absolute inset-0 -top-1.5 -left-6 border-b border-l z-0 rounded-bl-xl size-6 border-gray-200">
                </div>
            @endif
        </div>
        <div class="h-2 bg-slate-200 rounded w-24"></div>
        <div class="h-2 bg-slate-200 rounded w-12"></div>
        <span class="text-lg text-slate-200">•</span>
        <div class="h-2 bg-slate-200 rounded w-8"></div>
    </div>
    <div class="flex flex-col gap-2 w-full mt-0.5 ml-10">
        <div class="h-2 bg-slate-200 rounded w-3/4"></div>
        <div class="h-2 bg-slate-200 rounded w-2/3"></div>
        <div class="h-2 bg-slate-200 rounded w-1/2"></div>
        <div class="h-2 bg-slate-200 rounded w-1/3"></div>
    </div>
    <div class="relative flex items-center gap-4 w-full mt-4 ml-10">
        <x-icons.show size="18" class="text-gray-300 bg-white absolute -left-[33px] z-10" />
        <div class="rounded-full bg-slate-200 px-6 py-2.5"></div>
        <div class="rounded-full bg-slate-200 px-6 py-2.5"></div>
        <div class="rounded-full bg-slate-200 px-3 py-2.5"></div>
    </div>
</div>
