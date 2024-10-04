<div class="flex flex-col justify-center gap-7 rounded-xl border border-gray-100 bg-white p-6 shadow-md">
    <div class="flex flex-col gap-3">
        <h2 class="text-2xl font-medium text-gray-800">Fakülteler</h2>
        <div class="flex flex-col gap-5">
            @foreach ($faculties as $faculty)
                <div class="flex justify-between gap-5 rounded-md border border-gray-300 bg-gray-50 p-4">
                    <div class="flex flex-col">
                        <a target="_blank" href="{{ $faculty->url }}"
                            class="text-lg font-medium text-blue-600 hover:underline">{{ $faculty->name }}</a>
                        <span class="text-sm text-gray-500">{{ $faculty->description }}</span>
                    </div>
                    <button
                        class="mt-2 self-start rounded bg-primary px-6 py-2 font-medium text-white outline-none hover:bg-blue-900">
                        Katıl
                    </button>
                </div>
            @endforeach
        </div>
    </div>
    <div class="flex flex-col gap-3">
        <h2 class="text-2xl font-medium text-gray-800">Meslek Yüksekokulları</h2>
        <div class="flex flex-col gap-5">
            @foreach ($vocationals as $vocational)
                <div class="flex items-center justify-between gap-5 rounded-md border border-gray-300 bg-gray-50 p-4">
                    <div class="flex flex-col">
                        <a target="_blank" href="{{ $vocational->url }}"
                            class="text-lg font-medium text-blue-600 hover:underline">{{ $vocational->name }}</a>
                        <span class="text-sm text-gray-500">{{ $vocational->description }}</span>
                    </div>
                    <button
                        class="mt-2 self-start rounded bg-primary px-6 py-2 font-medium text-white outline-none hover:bg-blue-900">
                        Katıl
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>
