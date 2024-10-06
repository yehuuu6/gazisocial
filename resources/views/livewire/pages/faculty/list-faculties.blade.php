<div class="flex flex-col justify-center gap-5 rounded-xl border border-gray-100 bg-white p-6 shadow-md">
    <div class="flex flex-col gap-3">
        <h2 class="text-2xl font-medium text-gray-800">Fakülteler</h2>
        <div class="flex flex-col gap-5">
            @foreach ($faculties as $faculty)
                <div
                    class="group flex items-center justify-between gap-5 rounded-md border border-gray-300 bg-gray-50 p-4">
                    <div class="flex flex-col">
                        <a target="_blank" href="{{ $faculty->url }}"
                            class="text-lg font-medium text-blue-600 hover:underline">{{ $faculty->name }}</a>
                        <span class="text-sm text-gray-500">{{ $faculty->description }}</span>
                    </div>
                    @if (!Auth::user()->faculty)
                        <button wire:click="joinFaculty({{ $faculty->id }})"
                            class="hidden w-[75px] items-center justify-center rounded bg-primary px-6 py-2 font-medium text-white outline-none group-hover:flex hover:bg-blue-900">
                            <span class="flex items-center justify-center" wire:loading.remove
                                wire:target="joinFaculty">
                                Katıl
                            </span>
                            <span class="flex items-center justify-center" wire:loading.flex wire:target="joinFaculty">
                                <x-icons.spinner size='24' color='white' />
                            </span>
                        </button>
                    @else
                        @if (Auth::user()->faculty_id === $faculty->id)
                            <button wire:click="leaveFaculty()"
                                class="flex w-[75px] items-center justify-center rounded bg-red-500 px-6 py-2 font-medium text-white outline-none hover:bg-red-900">
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
    <div class="flex flex-col gap-3">
        <h2 class="text-2xl font-medium text-gray-800">Meslek Yüksekokulları</h2>
        <div class="flex flex-col gap-5">
            @foreach ($vocationals as $vocational)
                <div
                    class="group flex items-center justify-between gap-5 rounded-md border border-gray-300 bg-gray-50 p-4">
                    <div class="flex flex-col">
                        <a target="_blank" href="{{ $vocational->url }}"
                            class="text-lg font-medium text-blue-600 hover:underline">{{ $vocational->name }}</a>
                        <span class="text-sm text-gray-500">{{ $vocational->description }}</span>
                    </div>
                    @if (!Auth::user()->faculty)
                        <button wire:click="joinFaculty({{ $vocational->id }})"
                            class="hidden w-[75px] items-center justify-center rounded bg-primary px-6 py-2 font-medium text-white outline-none group-hover:flex hover:bg-blue-900">
                            <span class="flex items-center justify-center" wire:loading.remove
                                wire:target="joinFaculty">
                                Katıl
                            </span>
                            <span class="flex items-center justify-center" wire:loading.flex wire:target="joinFaculty">
                                <x-icons.spinner size='24' color='white' />
                            </span>
                        </button>
                    @else
                        @if (Auth::user()->faculty_id === $vocational->id)
                            <button wire:click="leaveFaculty()"
                                class="flex w-[75px] items-center justify-center rounded bg-red-500 px-6 py-2 font-medium text-white outline-none hover:bg-red-900">
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
