<div x-init="$wire.on('scroll-to-top', () => window.scrollTo({ top: 0, behavior: 'smooth' }))">
    <div wire:loading class="w-full">
        <x-post.indexer-placeholder />
    </div>
    <table class="w-full" wire:loading.table.remove>
        <thead id ="post-index">
            <tr class="border-b border-b-gray-200 text-xs text-gray-400">
                <th class="p-4 text-left font-normal uppercase" width="60%">
                    "{{ $this->tag->name }}" ETİKETİNE SAhİP KONULAR
                </th>
                <th class="p-4 text-center font-normal" width="10%">
                    <span class="hidden md:inline-block">YANITLAR</span>
                    <span class="md:hidden flex items-center justify-center">
                        <x-icons.comment size="14" />
                    </span>
                </th>
                <th class="hidden p-4 text-center font-normal md:table-cell" width="10%">
                    BEĞENİLER
                </th>
                <th class="p-4 text-center font-normal" width="20%">
                    <span class="hidden md:inline-block">OLUŞTURULDU</span>
                    <span class="md:hidden flex items-center justify-center">
                        <x-icons.time size="14" />
                    </span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($this->posts as $post)
                <livewire:post.indexer.post-item :$post :key="$post->id" />
            @empty
                <tr>
                    <td class="p-4 text-center" colspan="4">
                        <span class="text-gray-400">Sonuç bulunamadı.</span>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $this->posts->links('livewire.pagination.simple') }}
</div>
