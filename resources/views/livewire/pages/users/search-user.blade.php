<div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden border border-gray-100">
    <div wire:loading>
        <x-posts.placeholder />
    </div>
    <table wire:loading.table.remove class="w-full">
        <thead id ="user-index">
            <tr class="border-b border-b-gray-200 text-xs text-gray-400">
                <th class="p-4 font-normal text-left" width="50%">
                    AD SOYAD
                </th>
                <th class="p-4 font-normal text-center" width="30%">
                    ROLLER
                </th>
                <th class="p-4 font-normal text-center" width="20%">
                    SON AKTİVİTE
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($users as $user)
                <livewire:components.user.user-item :$user :key="$user->id" />
            @empty
                <tr>
                    <td class="p-4 text-center" colspan="4">
                        <span class="text-gray-400">Sonuç bulunamadı.</span>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $users->links('livewire.pagination.simple') }}
</div>
@script
    <script>
        $wire.on('scroll-to-top', function() {
            const postIndexer = document.getElementById('user-index');
            const offset = 75;
            const topPosition = postIndexer.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({
                top: topPosition,
                behavior: 'smooth'
            });
        });
    </script>
@endscript
