<div class="p-6 shadow-md overflow-hidden rounded-xl border border-gray-100 bg-white">
    <h1 class="text-3xl font-bold text-gray-900">{{ $bug->title }}</h1>
    <div class="flex flex-col gap-4 mt-4">
        <div class="flex flex-col gap-2">
            <span class="text-gray-600 font-semibold">Açıklama:</span>
            <article class="font-normal whitespace-pre-wrap">{{ $bug->description }}</article>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-gray-600 font-semibold">Durum:</span>
            <span>{{ $bug->status === 'pending' ? 'Beklemede' : 'Çözüldü' }}</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-gray-600 font-semibold">Bildiren:</span>
            <x-link href="{{ route('users.show', $bug->user->username) }}"
                class="text-blue-400">{{ $bug->user->name }}</x-link>
        </div>
    </div>
</div>
