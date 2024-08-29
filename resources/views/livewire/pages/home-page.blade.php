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
        <ul wire:loading.remove id="post-index" class="divide-y overflow-y-auto absolute h-full w-full">
            @foreach ($posts as $post)
                <x-posts.item :$post />
            @endforeach
        </ul>
    </div>
    {{ $posts->links() }}
</div>
@script
    <script>
        $wire.on('scroll-to-top', function() {
            const postIndexer = document.getElementById('post-index');
            postIndexer.scroll({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
@endscript
