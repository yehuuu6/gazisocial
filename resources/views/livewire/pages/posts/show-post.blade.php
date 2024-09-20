@section('canonical')
    <link rel="canonical" href="{{ $post->showRoute() }}">
@endsection
<div>
    <x-page-title>{{ $post->title }}</x-page-title>
    <div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden border border-gray-100">
        <livewire:components.post.details :$post lazy />
        <x-seperator />
        <h3 id="comment-header" class="p-4 text-xl font-bold">Yorumlar</h3>
        <ul wire:loading class="flex flex-1 flex-col gap-1 pb-5">
            @for ($i = 0; $i < 10; $i++)
                <x-comments.placeholder />
            @endfor
        </ul>
        <ul wire:loading.remove class="flex flex-1 flex-col gap-1 pb-5">
            @if ($comments->isEmpty())
                <li class="p-4 text-gray-500">Henüz yorum yapılmamış, ilk yorumu siz yapın!</li>
            @endif
            @foreach ($comments as $comment)
                <livewire:components.post.comment :$comment postAuthor="{{ $post->user->id }}" :key="$comment->id" />
            @endforeach
        </ul>
        {{ $comments->links('livewire.pagination.simple') }}
    </div>
    @script
        <script>
            $wire.on('scroll-to-header', function() {
                document.getElementById('comment-header').scrollIntoView({
                    behavior: 'smooth'
                });
            });
        </script>
    @endscript

</div>
