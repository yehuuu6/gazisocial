<div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden">
    <x-header-title>
        En Son Konular
    </x-header-title>

    <x-seperator />
    <div class="relative h-full">
        <ul wire:loading class="overflow-y-hidden absolute h-full w-full">
            @for ($i = 0; $i < 10; $i++)
                <x-posts.placeholder />
            @endfor
        </ul>
        <ul wire:loading.remove class="overflow-y-auto absolute h-full w-full">
            @foreach ($posts as $post)
                <x-posts.item :$post />
            @endforeach
        </ul>
    </div>
    {{ $posts->links() }}
</div>
