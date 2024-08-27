<div class="flex justify-between items-center px-4">
    <div class="flex gap-2 items-center justify-start">
        <h3 class="text-xl font-bold py-4">{{ $slot }}</h3>
    </div>
    <x-link href="/posts/create"
        class="py-2 px-5 bg-primary opacity-100 text-white rounded-md hover:opacity-80 focus:outline-none focus:ring-2 hover:no-underline">Konu
        Aç</x-link>
</div>
