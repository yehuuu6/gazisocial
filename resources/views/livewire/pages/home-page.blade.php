<div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden">

    <x-header-title>
        En Son Konular
    </x-header-title>

    <x-seperator />
    <x-scrollable-wrapper class="h-full" id="post-index">
        <ul wire:loading class="divide-y flex flex-1 flex-col gap-1 pb-5 w-full">
            @for ($i = 0; $i < 10; $i++)
                <x-posts.placeholder />
            @endfor
        </ul>
        <ul wire:loading.remove class="divide-y flex flex-1 flex-col gap-1 pb-5">
            @foreach ($posts as $post)
                <livewire:components.post.post-item :$post :key="$post->id" />
            @endforeach
        </ul>
    </x-scrollable-wrapper>
    {{ $posts->links('livewire.pagination.simple') }}
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
