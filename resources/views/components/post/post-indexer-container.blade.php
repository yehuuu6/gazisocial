<div>
    <div class="flex flex-col overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
        {{ $slot }}
    </div>
</div>
@script
    <script>
        $wire.on('scroll-to-top', function() {
            const postIndexer = document.getElementById('post-index');
            const offset = 75;
            const topPosition = postIndexer.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({
                top: topPosition,
                behavior: 'smooth'
            });
        });
    </script>
@endscript
