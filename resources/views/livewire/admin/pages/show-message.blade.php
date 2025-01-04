<div class="p-6 shadow-md overflow-hidden rounded-xl border border-gray-100 bg-white">
    <div class="flex justify-between">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold text-gray-900">{{ $message->name }}</h1>
            <span class="text-base font-normal text-gray-600">{{ $message->email }} tarafından
                gönderildi.</span>
        </div>
        <span class="text-sm text-gray-500 font-light">{{ $message->created_at->locale('tr')->diffForHumans() }}</span>
    </div>
    <div class="flex flex-col gap-4 mt-4">
        <div class="flex flex-col gap-2">
            <span class="text-gray-600 font-semibold">Kullanıcı Mesajı:</span>
            <article class="font-normal whitespace-pre-wrap">{{ $message->message }}</article>
        </div>
    </div>
</div>
