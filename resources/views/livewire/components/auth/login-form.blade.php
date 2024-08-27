<form wire:submit="login" class="bg-gray-50 border border-gray-200 px-8 pt-6 pb-8 mb-4 rounded-lg max-w-md w-full">
    @csrf
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5" role="alert">
            <ul class="pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="break-words">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-normal mb-2" for="email">
            E-posta
        </label>
        <input
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="email" type="email" name="email" value="{{ old('email') }}" required wire:model="email">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-normal mb-2" for="password">
            Şifre
        </label>
        <input
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            id="password" type="password" name="password" required wire:model="password">
    </div>
    <div class="flex items-center justify-between flex-col gap-3">
        <button wire:loading.class="animate-pulse"
            class="bg-primary opacity-90 hover:opacity-100 text-white font-medium py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
            type="submit">
            Giriş Yap
        </button>
    </div>
</form>
