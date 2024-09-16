<table class="w-full">
    <thead>
        <tr class="border-b border-b-gray-200 uppercase text-xs text-gray-400">
            <th class="p-4 font-normal text-left" width="70%">Konu</th>
            <th class="p-4 font-normal text-center" width="10%">Yanıtlar</th>
            <th class="hidden md:table-cell p-4 font-normal text-center" width="10%">Beğeniler</th>
            <th class="p-4 font-normal text-center" width="10%">Aktivite</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @for ($i = 0; $i < 10; $i++)
            <tr wire:key="post-placeholder-{{ $i }}">
                <td class="py-4 px-2">
                    <div class="animate-pulse items-center flex space-x-4">
                        <div class="hidden md:block rounded-full bg-slate-200 h-10 w-10"></div>
                        <div class="flex-1 space-y-3">
                            <div class="grid grid-cols-4 gap-4 md:w-1/6">
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                                <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                            </div>
                            <div class="h-2 bg-slate-200 rounded"></div>
                        </div>
                    </div>
                </td>
                <td class="p-4">
                    <div class="flex justify-center items-center">
                        <div class="h-2 bg-slate-200 rounded w-1/6"></div>
                    </div>
                </td>
                <td class="hidden md:table-cell p-4">
                    <div class="flex justify-center items-center">
                        <div class="h-2 bg-slate-200 rounded w-1/6"></div>
                    </div>
                </td>
                <td class="p-4">
                    <div class="flex justify-center items-center">
                        <div class="h-2 bg-slate-200 rounded w-1/3"></div>
                    </div>
                </td>
            </tr>
        @endfor
    </tbody>
</table>
