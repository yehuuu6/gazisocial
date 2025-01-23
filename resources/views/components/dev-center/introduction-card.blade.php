<div
    class="hover:shadow-md border border-gray-200 shadow rounded-md bg-white transition duration-200 flex flex-col items-center justify-center gap-2 md:gap-4 px-3 py-8">
    <div class="rounded-full bg-blue-50 p-2 text-blue-400">
        {{ $icon }}
    </div>
    <span class="text-sm md:text-lg font-normal text-gray-800">
        {{ $title }}
    </span>
    <p class="text-xs md:text-base font-light text-gray-600">
        {{ $description }}
    </p>
    {{ $button }}
</div>
