<div>
    <div wire:loading class="w-full">
        <x-post.indexer-placeholder />
    </div>
    <table class="w-full" wire:loading.table.remove>
        <thead id ="post-index">
            <tr class="border-b border-b-gray-200 text-xs text-gray-400">
                <th class="p-4 text-left font-normal" width="60%">
                    KONU | "{{ $query }}" için arama sonuçları
                </th>
                <th class="p-4 text-center font-normal" width="10%">
                    YANITLAR
                </th>
                <th class="hidden p-4 text-center font-normal md:table-cell" width="10%">
                    BEĞENİLER
                </th>
                <th class="p-4 text-center font-normal" width="20%">
                    OLUŞTURULDU
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($posts as $post)
                <livewire:post.indexer.post-item :$post :key="'post-index-item' . $post->id" />
            @empty
                <tr>
                    <td class="p-4 text-center" colspan="4">
                        <span class="text-gray-400">Sonuç bulunamadı.</span>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $posts->links('livewire.pagination.simple') }}
</div>
