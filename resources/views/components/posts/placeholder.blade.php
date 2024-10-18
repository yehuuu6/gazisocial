<div>
    <table class="w-full">
        <thead>
            <tr class="border-b border-b-gray-200 text-xs uppercase text-gray-400">
                <th class="p-4 text-left font-normal" width="60%">KONU</th>
                <th class="p-4 text-center font-normal" width="10%">YANITLAR</th>
                <th class="hidden p-4 text-center font-normal md:table-cell" width="10%">BEĞENİLER</th>
                <th class="p-4 text-center font-normal" width="20%">OLUŞTURULDU</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @for ($i = 0; $i < rand(4, 20); $i++)
                <tr wire:key="post-placeholder-{{ $i }}">
                    <td class="px-2 py-4">
                        <div class="flex animate-pulse items-center space-x-4">
                            <div class="hidden h-10 w-10 rounded-full bg-slate-200 md:block"></div>
                            <div class="flex-1 space-y-3">
                                <div class="grid grid-cols-4 gap-4 md:w-1/6">
                                    <div class="col-span-1 h-2 rounded bg-slate-200"></div>
                                    <div class="col-span-1 h-2 rounded bg-slate-200"></div>
                                    <div class="col-span-1 h-2 rounded bg-slate-200"></div>
                                    <div class="col-span-1 h-2 rounded bg-slate-200"></div>
                                </div>
                                <div class="h-2 rounded bg-slate-200"></div>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-center">
                            <div class="h-2 w-1/6 rounded bg-slate-200"></div>
                        </div>
                    </td>
                    <td class="hidden p-4 md:table-cell">
                        <div class="flex items-center justify-center">
                            <div class="h-2 w-1/6 rounded bg-slate-200"></div>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-center">
                            <div class="h-2 w-1/3 rounded bg-slate-200"></div>
                        </div>
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>

</div>
