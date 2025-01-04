<div x-data="{}" class="flex flex-col overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
    <div class="m-3.5 grid gap-5 md:m-5 lg:grid-cols-[1fr_350px] lg:gap-10">
        <div class="flex flex-col gap-10">
            <x-user.edit.container>
                <x-user.edit.title title="Profil Bilgileri" description="Profilinizi güncelleyin" />
                <x-seperator />
                <form wire:submit="updateProfileInfo">
                    <div class="flex flex-col gap-5 py-4">
                        <div class="flex flex-col gap-2 px-4">
                            <label for="name" class="block font-medium text-gray-700">İsim</label>
                            <input wire:model="name" type="text" id="name" name="name" autocomplete="off"
                                required maxlength="30"
                                class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500" />
                        </div>
                        <div class="flex flex-col gap-2 px-4">
                            <label for="username" class="block font-medium text-gray-700">Kullanıcı Adı</label>
                            <input wire:model="username" type="text" id="username" name="username"
                                autocomplete="off" required maxlength="30"
                                class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500" />
                        </div>
                        <div class="flex flex-col gap-2 px-4">
                            <label for="email" class="block font-medium text-gray-700">
                                <span>E-posta</span>
                                @if (Auth::user()->hasVerifiedEmail())
                                    @if (Auth::user()->isStudent())
                                        <span class="ml-1 rounded-full bg-green-500 px-2 py-1 text-xs text-white">
                                            Gazi Üniversitesine bağlılığınız onaylandı
                                        </span>
                                    @else
                                        <span class="ml-1 rounded-full bg-blue-500 px-2 py-1 text-xs text-white">
                                            E posta adresiniz onaylandı
                                        </span>
                                    @endif
                                @else
                                    <a href="{{ route('verification.notice') }}"
                                        class="ml-1 rounded-full bg-red-500 px-2 py-1 text-xs text-white hover:bg-opacity-90 hover:no-underline">E-posta
                                        adresinizi onaylayın</a>
                                @endif
                            </label>
                            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                                readonly autocomplete="email"
                                class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-500 focus:outline-none" />
                        </div>
                        <div class="flex flex-col gap-2 px-4">
                            <label for="bio" class="block font-medium text-gray-700">Biyografi</label>
                            <textarea wire:model="bio" id="bio" name="bio" rows="5" placeholder="Herhangi bir bilgi verilmemiş."
                                maxlength="255"
                                class="block w-full resize-none rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">{{ Auth::user()->bio }}</textarea>
                        </div>
                    </div>
                    <x-seperator />
                    <div class="flex justify-end bg-gray-50 p-6">
                        <button type="submit" wire:loading.attr="disabled" wire:target="updateProfileInfo"
                            wire:loading.class="animate-pulse"
                            class="rounded bg-blue-500 px-6 py-2 font-medium text-white hover:bg-blue-600">
                            Değişiklikleri Uygula
                        </button>
                    </div>
                </form>
            </x-user.edit.container>
            <x-user.edit.container>
                <x-user.edit.title title="Şifre Değiştir" description="Hesap şifrenizi güncelleyin" />
                <x-seperator />
                <form wire:submit="updatePassword">
                    <div class="flex flex-col gap-5 py-4">
                        <div class="flex flex-col gap-2 px-4">
                            <label for="current_password" class="block font-medium text-gray-700">Mevcut
                                Şifre</label>
                            <input wire:model="current_password" type="password" id="current_password"
                                placeholder="********" name="current_password" required
                                class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500" />
                        </div>
                        <div class="flex flex-col gap-2 px-4">
                            <label for="password" class="block font-medium text-gray-700">Yeni
                                Şifre</label>
                            <input wire:model="password" type="password" id="password" name="password"
                                placeholder="********" required
                                class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500" />
                        </div>
                        <div class="flex flex-col gap-2 px-4">
                            <label for="password_confirmation" class="block font-medium text-gray-700">Şifre
                                Onayı</label>
                            <input wire:model="password_confirmation" type="password" id="password_confirmation"
                                name="password_confirmation" placeholder="********" required
                                class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500" />
                        </div>
                    </div>
                    <x-seperator />
                    <div class="flex justify-end bg-gray-50 p-6">
                        <button type="submit" wire:loading.attr="disabled" wire:target="updatePassword"
                            wire:loading.class="animate-pulse"
                            class="rounded bg-blue-500 px-6 py-2 font-medium text-white hover:bg-blue-600">
                            Şifreyi Güncelle
                        </button>
                    </div>
                </form>
            </x-user.edit.container>
        </div>
        <div class="flex flex-col gap-10">
            @if (Auth::user()->isStudent())
                @if (!Auth::user()->faculty)
                    <x-user.edit.container :renderBadge="true">
                        <x-user.edit.title title="Fakülte"
                            description="Görünüşe göre Gazi Üniversitesi öğrencisisin. Profilini tamamlamak için hangi fakülteden olduğunu belirt!" />
                        <x-seperator />
                        <div class="flex flex-col gap-3 p-4">
                            <x-link
                                class="rounded bg-blue-500 px-6 py-2 text-center font-medium text-white hover:bg-blue-600 hover:no-underline"
                                href="{{ route('faculties') }}">
                                Fakülteleri Gör
                            </x-link>
                        </div>
                    </x-user.edit.container>
                @else
                    <x-user.edit.container :renderBadge="true">
                        <x-user.edit.title title="Fakülte" description="Profilinizde görünen fakülte" />
                        <x-seperator />
                        <div class="flex flex-col p-4">
                            <h3 class="font-medium text-gray-700">
                                {{ Auth::user()->faculty->name }}
                            </h3>
                            <span class="text-sm text-gray-500">
                                {{ Auth::user()->faculty->description }}
                            </span>
                            <button wire:click="leaveFaculty({{ Auth::user()->faculty->id }})"
                                class="mt-3 rounded bg-blue-500 px-6 py-2 text-center font-medium text-white hover:bg-blue-600">
                                <span class="flex items-center justify-center" wire:loading.remove
                                    wire:target="leaveFaculty">
                                    Ayrıl
                                </span>
                                <span class="flex items-center justify-center" wire:loading.flex
                                    wire:target="leaveFaculty">
                                    <x-icons.spinner size='24' color='white' />
                                </span>
                            </button>
                        </div>
                    </x-user.edit.container>
                @endif
            @endif
            <x-user.edit.container>
                <x-user.edit.title title="Gizlilik Tercihleri" description="Gizlilik tercihlerinizi güncelleyin" />
                <x-seperator />
                <form wire:submit="updatePrivacyInfo">
                    <div class="flex flex-col gap-3 p-4">
                        <div class="flex flex-col gap-2">
                            <label for="profile-visibility" class="block font-medium text-gray-700">Görünürlük</label>
                            <select wire:model="profileVisibility" id="profile-visibility" name="profile-visibility"
                                class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
                                <option value="public">Herkese Açık</option>
                                <option value="private">Gizli</option>
                            </select>
                        </div>
                        <button type="submit" wire:loading.attr="disabled" wire:target="updatePrivacyInfo"
                            wire:loading.class="animate-pulse"
                            class="mt-2 rounded bg-blue-500 px-4 py-2 font-medium text-white hover:bg-blue-600">
                            Tercihlerimi Kaydet
                        </button>
                    </div>
                </form>
            </x-user.edit.container>
            <x-user.edit.container>
                <x-user.edit.title title="Hesabı Sil" description="Hesabınızı kalıcı olarak silin" />
                <x-seperator />
                <div class="flex flex-col gap-3 p-4">
                    <span class="font-normal text-gray-500">
                        Hesabınızı silmek geri döndürülemez bir işlemdir ve tüm verileriniz kalıcı olarak
                        silinecektir.
                    </span>
                    <button x-on:click="deleteAccountModal = true"
                        class="mt-2 rounded-md bg-red-500 px-4 py-2 font-medium text-white hover:bg-red-600">
                        Hesabı Sil
                    </button>
                </div>
            </x-user.edit.container>
        </div>
    </div>
</div>
