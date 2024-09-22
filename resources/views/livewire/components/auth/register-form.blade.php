<form wire:submit="register" class="bg-gray-50 border border-gray-200 px-8 pt-6 pb-8 mb-4 rounded-lg">
    @csrf
    <div class="mb-4 flex gap-4">
        <div>
            <label class="block text-gray-700 text-sm font-normal mb-2" for="name">
                Ad Soyad
            </label>
            <input maxlength="30"
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="name" type="text" name="name" value="{{ old('name') }}" required wire:model="name">
        </div>
        <div>
            <label for="username" class="block text-gray-700 text-sm font-normal mb-2">
                Kullanıcı Adı
            </label>
            <input maxlength="30"
                class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="username" type="text" name="username" value="{{ old('username') }}" required
                wire:model="username">
        </div>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-normal mb-2" for="email">
            E-posta
        </label>
        <input placeholder="ornek@gazi.edu.tr" maxlength="255"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="email" type="email" name="email" value="{{ old('email') }}" wire:model="email"
            autocomplete="mail" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-normal mb-2" for="password">
            Şifre
        </label>
        <input minlength="8"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            id="password" type="password" name="password" required wire:model="password">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-normal mb-2" for="password">
            Şifreyi Onayla
        </label>
        <input minlength="8"
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            id="password_confirmation" type="password" name="password_confirmation" required
            wire:model="password_confirmation">
    </div>


    <div class="flex items-center justify-between flex-col gap-3">
        <button wire:loading.class="bg-gray-300 cursor-not-allowed" wire:loading.class.remove="bg-primary"
            class="bg-primary flex items-center justify-center gap-1 opacity-90 h-[40px] hover:opacity-100 text-white font-medium py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
            type="submit">
            <x-icons.spinner wire:loading size="32" color="#479fff" />
            <span wire:loading.remove>Kayıt Ol</span>
        </button>
    </div>
</form>
