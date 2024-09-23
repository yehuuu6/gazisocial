<div>
    <x-page-title>
        Profili Düzenle
    </x-page-title>
    <div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden border border-gray-100">
        <div class="grid gap-5 m-3.5 lg:gap-10 md:m-5 lg:grid-cols-[1fr_350px]">
            <div class="flex flex-col gap-10">
                <x-users.edit.container>
                    <x-users.edit.title title="Profil Bilgileri" description="Profilinizi güncelleyin" />
                    <x-seperator />
                    <form wire:submit="updateProfileInfo" enctype="multipart/form-data">
                        <div class="flex flex-col gap-5 py-4">
                            <div class="flex flex-col gap-2 px-4">
                                <label for="name" class="block font-medium text-gray-700">İsim</label>
                                <input wire:model="name" type="text" id="name" name="name" autocomplete="off"
                                    required maxlength="30"
                                    class="block w-full bg-gray-50 px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                            <div class="flex flex-col gap-2 px-4">
                                <label for="username" class="block font-medium text-gray-700">Kullanıcı Adı</label>
                                <input wire:model="username" type="text" id="username" name="username"
                                    autocomplete="off" required maxlength="30"
                                    class="bg-gray-50 block w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                            <div class="flex flex-col gap-2 px-4">
                                <label for="email" class="block font-medium text-gray-700">
                                    <span>E-posta</span>
                                    @if (Auth::user()->hasVerifiedEmail())
                                        @if (Auth::user()->isStudent())
                                            <span class="text-xs bg-green-500 ml-1 py-1 px-2 rounded-full text-white">
                                                Gazi Üniversitesine bağlılığınız onaylandı
                                            </span>
                                        @else
                                            <span class="text-xs bg-blue-500 ml-1 py-1 px-2 rounded-full text-white">
                                                E posta adresiniz onaylandı
                                            </span>
                                        @endif
                                    @else
                                        <a href="{{ route('verification.notice') }}"
                                            class="text-xs bg-red-500 ml-1 py-1 px-2 rounded-full text-white hover:no-underline hover:bg-opacity-90">E-posta
                                            adresinizi onaylayın</a>
                                    @endif
                                </label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                                    readonly
                                    class="bg-gray-50 text-gray-500 block w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none" />
                            </div>
                            <div class="flex flex-col gap-2 px-4">
                                <label for="bio" class="block font-medium text-gray-700">Biyografi</label>
                                <textarea wire:model="bio" id="bio" name="bio" rows="5" placeholder="Herhangi bir bilgi verilmemiş."
                                    maxlength="255"
                                    class="bg-gray-50 resize-none block w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ Auth::user()->bio }}</textarea>
                            </div>
                        </div>
                        <x-seperator />
                        <div class="flex justify-end bg-gray-50 p-6">
                            <button type="submit" wire:loading.attr="disabled" wire:target="updateProfileInfo"
                                wire:loading.class="animate-pulse"
                                class="px-6 py-2 bg-blue-500 text-white font-medium rounded hover:bg-blue-600">
                                Değişiklikleri Uygula
                            </button>
                        </div>
                    </form>
                </x-users.edit.container>
                <x-users.edit.container>
                    <x-users.edit.title title="Şifre Değiştir" description="Hesap şifrenizi güncelleyin" />
                    <x-seperator />
                    <form wire:submit="updatePassword" enctype="multipart/form-data">
                        <div class="flex flex-col gap-5 py-4">
                            <div class="flex flex-col gap-2 px-4">
                                <label for="current_password" class="block font-medium text-gray-700">Mevcut
                                    Şifre</label>
                                <input wire:model="current_password" type="password" id="current_password"
                                    placeholder="********" name="current_password" required
                                    class="bg-gray-50 block w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                            <div class="flex flex-col gap-2 px-4">
                                <label for="password" class="block font-medium text-gray-700">Yeni
                                    Şifre</label>
                                <input wire:model="password" type="password" id="password" name="password"
                                    placeholder="********" required
                                    class="bg-gray-50 block w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                            <div class="flex flex-col gap-2 px-4">
                                <label for="password_confirmation" class="block font-medium text-gray-700">Şifre
                                    Onayı</label>
                                <input wire:model="password_confirmation" type="password" id="password_confirmation"
                                    name="password_confirmation" placeholder="********" required
                                    class="bg-gray-50 block w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                        </div>
                        <x-seperator />
                        <div class="flex justify-end bg-gray-50 p-6">
                            <button type="submit" wire:loading.attr="disabled" wire:target="updatePassword"
                                wire:loading.class="animate-pulse"
                                class="px-6 py-2 bg-blue-500 text-white font-medium rounded hover:bg-blue-600">
                                Şifreyi Güncelle
                            </button>
                        </div>
                    </form>
                </x-users.edit.container>
            </div>
            <div class="flex flex-col gap-10">
                <x-users.edit.container>
                    <x-users.edit.title title="Gizlilik Tercihleri" description="Gizlilik tercihlerinizi güncelleyin" />
                    <x-seperator />
                    <form wire:submit="updatePrivacyInfo" enctype="multipart/form-data">
                        <div class="flex flex-col gap-3 p-4">
                            <div class="flex flex-col gap-2">
                                <label for="profile-visibility"
                                    class="block font-medium text-gray-700">Görünürlük</label>
                                <select wire:model="profileVisibility" id="profile-visibility"
                                    name="profile-visibility"
                                    class="bg-gray-50 block w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="public">Herkese Açık</option>
                                    <option value="private">Gizli</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="badge-visibility" class="block font-medium text-gray-700">Rozetler</label>
                                <select wire:model="badgeVisibility" id="badge-visibility" name="badge-visibility"
                                    class="bg-gray-50 block w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="default">Varsayılan</option>
                                    <option value="partial">Kısmi</option>
                                    <option value="hidden">Gizli</option>
                                </select>
                            </div>
                            <button type="submit" wire:loading.attr="disabled" wire:target="updatePrivacyInfo"
                                wire:loading.class="animate-pulse"
                                class="px-4 py-2 mt-2 bg-blue-500 text-white font-medium rounded hover:bg-blue-600">
                                Tercihlerimi Kaydet
                            </button>
                        </div>
                    </form>
                </x-users.edit.container>
                <x-users.edit.container>
                    <x-users.edit.title title="Hesabı Sil" description="Hesabınızı kalıcı olarak silin" />
                    <x-seperator />
                    <form wire:submit="deleteAccountPermanently" enctype="multipart/form-data">
                        <div class="flex flex-col gap-3 p-4">
                            <span class="text-gray-500 font-normal">
                                Hesabınızı silmek geri döndürülemez bir işlemdir ve tüm verileriniz kalıcı olarak
                                silinecektir.
                            </span>
                            <button type="submit" wire:loading.attr="disabled"
                                wire:target="deleteAccountPermanently" wire:loading.class="animate-pulse"
                                class="px-4 py-2 mt-2 bg-red-500 text-white font-medium rounded-md hover:bg-red-600"
                                wire:click="confirmDeleteAccount">
                                Hesabı Sil
                            </button>
                        </div>
                    </form>
                </x-users.edit.container>
            </div>
        </div>
    </div>
</div>
