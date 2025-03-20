<div class="flex flex-col justify-center gap-6 rounded-xl border border-gray-200 bg-white p-8 shadow-lg">
    <div class="flex flex-col gap-5">
        <div>
            <h2 class="text-3xl font-bold text-primary">Gazi Üniversitesi Fakülteleri</h2>
            <p class="text-gray-500 text-base font-normal mt-1">
                Profilinizde gösterilecek olan fakülteyi seçebilirsiniz.
            </p>
        </div>
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            @foreach ($faculties as $faculty)
                <div
                    class="group flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition-all duration-300">
                    <div class="flex flex-col">
                        <a target="_blank" href="{{ $faculty->url }}"
                            class="text-xl self-start font-semibold text-primary hover:underline">{{ $faculty->name }}</a>
                        <span class="mt-1 text-sm text-gray-600">{{ $faculty->description }}</span>
                    </div>
                    @can('join', App\Models\Faculty::class)
                        <button wire:click="joinFaculty({{ $faculty->id }})"
                            class="mt-2 self-start rounded-full bg-primary px-6 py-2 font-medium text-white outline-none transition-colors duration-300 hover:bg-blue-900 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <span class="flex items-center justify-center" wire:loading.remove
                                wire:target="joinFaculty({{ $faculty->id }})">
                                Katıl
                            </span>
                            <span class="flex items-center justify-center" wire:loading.flex
                                wire:target="joinFaculty({{ $faculty->id }})">
                                <x-icons.spinner size='24' color='white' />
                            </span>
                        </button>
                    @endcan
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-6 flex flex-col gap-5">
        <h2 class="text-3xl font-bold text-primary">Meslek Yüksekokulları</h2>
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            @foreach ($vocationals as $vocational)
                <div
                    class="flex flex-col gap-3 rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition-all duration-300">
                    <div class="flex flex-col">
                        <a target="_blank" href="{{ $vocational->url }}"
                            class="text-xl self-start font-semibold text-primary hover:underline">{{ $vocational->name }}</a>
                        <span class="mt-1 text-sm text-gray-600">{{ $vocational->description }}</span>
                    </div>
                    @if (!Auth::user()->faculty)
                        <button wire:click="joinFaculty({{ $vocational->id }})"
                            class="mt-2 self-start rounded-full bg-primary px-6 py-2 font-medium text-white outline-none transition-colors duration-300 hover:bg-blue-900 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <span class="flex items-center justify-center" wire:loading.remove
                                wire:target="joinFaculty({{ $vocational->id }})">
                                Katıl
                            </span>
                            <span class="flex items-center justify-center" wire:loading.flex
                                wire:target="joinFaculty({{ $vocational->id }})">
                                <x-icons.spinner size='24' color='white' />
                            </span>
                        </button>
                    @else
                        @if (Auth::user()->faculty_id === $vocational->id)
                            <button wire:click="leaveFaculty()"
                                class="mt-2 self-start rounded-full bg-red-500 px-6 py-2 font-medium text-white outline-none transition-colors duration-300 hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <span class="flex items-center justify-center" wire:loading.remove
                                    wire:target="leaveFaculty">
                                    Ayrıl
                                </span>
                                <span class="flex items-center justify-center" wire:loading.flex
                                    wire:target="leaveFaculty">
                                    <x-icons.spinner size='24' color='white' />
                                </span>
                            </button>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
