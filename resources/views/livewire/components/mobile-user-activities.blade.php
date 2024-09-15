<div id="responsive-user-activities"
    class="absolute top-[3.5rem] w-2/3 h-2/3 -right-2/3 transition-all duration-100 rounded-b-lg bg-primary z-10 md:hidden">
    <x-scrollable-wrapper class="h-full" scrollTheme="dark" wire:poll.30s>
        @foreach ($activities as $activity)
            <div class="flex flex-col py-2 px-4 user-activity gap-2">
                <div class="flex justify-between items-center">
                    <div class="flex gap-2 items-center">
                        <img class="size-8 rounded-full object-cover" src="{{ $activity->user->avatar }}" alt="avatar">
                        <x-link href="/u/{{ $activity->user->username }}"
                            class="font-medium text-white">{{ $activity->user->name }}</x-link>
                    </div>
                    <span
                        class="text-gray-200 text-xs">{{ $activity->created_at->locale('tr')->shortAbsoluteDiffForHumans() }}</span>
                </div>
                <p class="text-gray-200 text-sm">
                    {{ $activity->content }}
                    @if ($activity->link)
                        <x-link class="text-blue-300 font-medium" href="{{ $activity->link }}">Göz at</x-link>
                    @endif
                </p>
            </div>
        @endforeach
    </x-scrollable-wrapper>
</div>
