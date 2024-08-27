<div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden">
    <x-header-title>
        Konu Detayları
    </x-header-title>
    <x-seperator />
    <div class="relative h-full">
        <div class="absolute overflow-y-auto h-full w-full">
            <livewire:components.post.details :$post />
            <x-seperator />
            <h3 id="comment-header" class="p-4 text-xl font-bold">Yorumlar</h3>
            <ul wire:loading class="pb-5 w-full">
                @for ($i = 0; $i < 10; $i++)
                    <x-posts.placeholder />
                @endfor
            </ul>
            <ul wire:loading.remove class="flex flex-1 flex-col gap-1 pb-5">
                @if ($comments->isEmpty())
                    <li class="p-4 text-gray-500">Henüz yorum yapılmamış, ilk yorumu siz yapın!</li>
                @endif
                @foreach ($comments as $comment)
                    <livewire:components.post.comment :$comment :key="$comment->id" />
                @endforeach
            </ul>
        </div>
    </div>
    <div>
        {{ $comments->links() }}
    </div>
</div>
@script
    <script>
        Livewire.on('scroll-to-header', function() {
            document.getElementById('comment-header').scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>
@endscript
