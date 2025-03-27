<div class="flex flex-col overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
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
                                required maxlength="30" spellcheck="false"
                                class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500" />
                        </div>
                        <div class="flex flex-col gap-2 px-4">
                            <label for="username" class="block font-medium text-gray-700">Kullanıcı Adı</label>
                            <input type="text" id="username" name="username" spellcheck="false" autocomplete="off"
                                readonly maxlength="30" placeholder="{{ Auth::user()->username }}" disabled
                                class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500" />
                        </div>
                        <div class="flex flex-col gap-2 px-4">
                            <label for="email" class="flex flex-col md:block font-medium text-gray-700">
                                <span>E-posta</span>
                                @if (Auth::user()->hasVerifiedEmail())
                                    @if (Auth::user()->isStudent())
                                        <span
                                            class="md:ml-1 rounded-full bg-green-500 px-2 py-1 text-xs text-white self-start">
                                            Gazi Üniversitesine bağlılığınız onaylandı
                                        </span>
                                    @else
                                        <span
                                            class="md:ml-1 rounded-full bg-primary px-2 py-1 text-xs text-white self-start">
                                            E posta adresiniz onaylandı
                                        </span>
                                    @endif
                                @else
                                    <a href="{{ route('verification.notice') }}"
                                        class="ml-1 rounded-full bg-red-500 px-2 py-1 text-xs self-start text-white hover:bg-opacity-90 hover:no-underline">E-posta
                                        adresinizi onaylayın</a>
                                @endif
                            </label>
                            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                                readonly autocomplete="email"
                                class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-gray-500 focus:outline-none" />
                        </div>
                        <div class="flex flex-col gap-2 px-4">
                            <label for="bio" class="block font-medium text-gray-700">Biyografi</label>
                            <textarea wire:model="bio" spellcheck="false" id="bio" name="bio" rows="5"
                                placeholder="Herhangi bir bilgi verilmedi." maxlength="255"
                                class="block w-full resize-none rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">{{ Auth::user()->bio }}</textarea>
                        </div>
                    </div>
                    <x-seperator />
                    <div class="flex justify-end bg-gray-50 p-6">
                        <button type="submit" wire:loading.attr="disabled" wire:target="updateProfileInfo"
                            wire:loading.class="animate-pulse"
                            class="rounded bg-primary px-6 py-2 font-medium text-white hover:bg-blue-900">
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
                            class="rounded bg-primary px-6 py-2 font-medium text-white hover:bg-blue-900">
                            Şifreyi Güncelle
                        </button>
                    </div>
                </form>
            </x-user.edit.container>
        </div>
        <div class="flex flex-col gap-10">
            <x-user.edit.container>
                <x-user.edit.title title="Profil Fotoğrafı"
                    description="Profilinizde görünen fotoğrafınızı güncelleyin" />
                <x-seperator />
                <div>
                    <div class="flex gap-4 justify-between p-4">
                        <div class="shrink-0">
                            @if ($avatar)
                                <img src="{{ $avatar->temporaryUrl() }}"
                                    class="mx-auto object-cover size-20 rounded-full bg-gray-100"
                                    alt="Profil Fotoğrafı" />
                            @else
                                <img src="{{ $user->getAvatar() }}" x-on:updated-avatar="$wire.$refresh()"
                                    class="mx-auto object-cover size-20 rounded-full bg-gray-100"
                                    alt="Profil Fotoğrafı" />
                            @endif
                        </div>
                        <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                            x-on:livewire-upload-finish="uploading = false"
                            x-on:livewire-upload-cancel="uploading = false"
                            x-on:livewire-upload-error="uploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <div class="flex items-center gap-2">
                                <label x-show="!uploading" for="profile-avatar" wire:loading.remove
                                    wire:target="photo, deleteAvatar"
                                    class="cursor-pointer w-full inline-flex self-start items-center justify-center gap-2 rounded border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <x-icons.camera size="16" />
                                    <span>Yükle</span>
                                </label>
                                <input type="file" id="profile-avatar" name="profile-avatar" accept="image/*"
                                    class="hidden" wire:model="avatar" />
                                @if ($this->user->avatar)
                                    <button x-show="!uploading" wire:click="deleteAvatar" wire:loading.remove
                                        wire:target="photo, deleteAvatar"
                                        class="inline-flex w-full ml-2 self-start items-center justify-center gap-2 rounded border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-500 hover:bg-red-50">
                                        <x-icons.trash size="16" />
                                        <span>Kaldır</span>
                                    </button>
                                @endif
                            </div>
                            <div x-cloak x-show="uploading" class="mt-3 w-full">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-primary h-2.5 rounded-full transition-all duration-300 ease-in-out"
                                            x-bind:style="`width: ${progress}%`"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 font-medium"
                                        x-text="`${Math.round(progress)}%`"></span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1 flex items-center">
                                    <x-icons.spinner size="14" class="text-primary mr-1" />
                                    <span>Fotoğraf yükleniyor...</span>
                                </p>
                            </div>
                            <div wire:loading wire:target="deleteAvatar">
                                <div class="inline-flex items-center justify-start gap-2 text-primary">
                                    <x-icons.spinner size="16" class="text-primary shrink-0" />
                                    <span class="text-sm">
                                        Siliniyor...
                                    </span>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 mt-3">
                                <p>Desteklenen formatlar: JPG, PNG, GIF</p>
                                <p>Maksimum dosya boyutu: 2MB</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        @if ($avatar)
                            <button wire:click="saveAvatar" wire:loading.attr="disabled" wire:target="saveAvatar"
                                class="mt-3 w-full rounded bg-primary px-6 py-2 text-center font-medium text-white hover:bg-blue-900">
                                <span class="flex items-center justify-center" wire:loading.remove
                                    wire:target="saveAvatar">
                                    Avatarı Kaydet
                                </span>
                                <span class="flex items-center justify-center" wire:loading.flex
                                    wire:target="saveAvatar">
                                    <x-icons.spinner size='24' color='white' />
                                </span>
                            </button>
                        @else
                            <button type="button" disabled
                                class="rounded bg-gray-200 w-full px-6 py-2 font-medium text-gray-500 cursor-not-allowed">
                                Fotoğraf Seçilmedi
                            </button>
                        @endif
                    </div>
                </div>
            </x-user.edit.container>
            @if (Auth::user()->isStudent())
                @if (!Auth::user()->faculty)
                    <x-user.edit.container :renderBadge="true">
                        <x-user.edit.title title="Fakülte"
                            description="Görünüşe göre Gazi Üniversitesi öğrencisisin. Profilini tamamlamak için hangi fakülteden olduğunu belirt!" />
                        <x-seperator />
                        <div class="flex flex-col gap-3 p-4">
                            <x-link
                                class="rounded bg-primary px-6 py-2 text-center font-medium text-white hover:bg-blue-900 hover:no-underline"
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
                            <button wire:click="leaveFaculty({{ Auth::user()->faculty->id }})"
                                class="mt-3 rounded bg-primary px-6 py-2 text-center font-medium text-white hover:bg-blue-900">
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
                <x-user.edit.title title="Cinsiyet" description="Cinsiyetinizi güncelleyin" />
                <x-seperator />
                <form wire:submit="updateGender">
                    <div class="flex flex-col gap-3 p-4">
                        <div class="flex flex-col gap-2">
                            <label for="gender" class="block font-medium text-gray-700">Cinsiyet</label>
                            <select wire:model="gender" id="gender" name="gender"
                                class="block w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
                                <option value="erkek">Erkek</option>
                                <option value="kadın">Kadın</option>
                            </select>
                        </div>
                        <button type="submit" wire:loading.attr="disabled" wire:target="updateGender"
                            wire:loading.class="animate-pulse"
                            class="mt-2 rounded bg-primary px-4 py-2 font-medium text-white hover:bg-blue-900">
                            Kaydet
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
                    <button x-on:click="$wire.deleteAccountModal = true"
                        class="mt-2 rounded-md bg-red-500 px-4 py-2 font-medium text-white hover:bg-red-600">
                        Hesabı Sil
                    </button>
                </div>
            </x-user.edit.container>
        </div>
    </div>

    <!-- Hesap Silme Onay Modalı -->
    <div wire:transition.opacity x-cloak wire:show="deleteAccountModal"
        class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 grid place-items-center transition-all duration-300 ease-in-out">
        <div wire:transition.scale wire:show="deleteAccountModal"
            class="rounded-xl overflow-hidden shadow-lg bg-white relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg w-full h-fit transform transition-all duration-300">
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white">
                <h3 class="px-6 py-4 text-lg font-semibold text-white flex items-center gap-2">
                    <x-icons.trash size="24" />
                    Hesap Silme Onayı
                </h3>
            </div>
            <div class="px-6 py-4">
                <div class="mb-4">
                    <h4 class="text-gray-800 font-semibold text-base mb-2">Bu işlem geri alınamaz!</h4>
                    <p class="text-gray-600 text-sm">
                        Hesabınızı silmek, şunları kalıcı olarak silecektir:
                    </p>
                    <ul class="list-disc text-sm text-gray-600 ml-6 mt-2 space-y-1">
                        <li>Tüm kişisel verileriniz ve profil bilgileriniz</li>
                        <li>Paylaştığınız gönderiler ve yorumlar</li>
                    </ul>
                </div>
                <div class="mt-6">
                    <form wire:submit.prevent="deleteAccount">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                            <p class="text-red-600 text-sm font-medium">
                                Hesabınızı silmek için lütfen "ONAYLA" yazın.
                            </p>
                            <input type="text" wire:model="deleteAccountConfirmation" required
                                class="mt-2 w-full rounded-md border border-red-300 bg-white px-3 py-2 text-sm text-gray-700 focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500"
                                placeholder="ONAYLA" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-gray-50 p-5 flex items-center justify-end gap-3 border-t border-gray-100">
                <button type="button" x-on:click="$wire.deleteAccountModal = false"
                    class="rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 transition-colors duration-200">
                    İptal
                </button>
                <button type="button" wire:click="deleteAccount"
                    class="rounded bg-red-500 px-4 py-2 text-sm font-medium text-white hover:bg-red-600 transition-colors duration-200"
                    wire:loading.attr="disabled" wire:target="deleteAccount">
                    <span wire:loading.remove wire:target="deleteAccount" class="flex items-center gap-1">
                        <x-icons.trash size="16" />
                        Hesabımı Sil
                    </span>
                    <span wire:loading.flex wire:target="deleteAccount" class="flex items-center gap-1">
                        <x-icons.spinner size="16" class="text-white" />
                        İşleniyor...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
