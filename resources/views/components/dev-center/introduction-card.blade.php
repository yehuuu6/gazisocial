@props(['bgClass'])
<div
    class="hover:shadow-md shadow rounded-md {{ $bgClass }} transition duration-200 flex flex-col items-center justify-center gap-2 md:gap-4 px-3 py-8">
    <div class="rounded-full bg-gradient-to-tl from-indigo-800 to-sky-400 p-3 text-blue-50 shadow">
        {{ $icon }}
    </div>
    <span class="text-sm md:text-lg font-medium text-gray-800">
        {{ $title }}
    </span>
    <p class="text-xs md:text-base font-normal text-gray-700 mx-16">
        {{ $description }}
    </p>
    {{ $button }}
</div>
