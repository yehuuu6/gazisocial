<x-scrollable-wrapper class="h-1/2 hidden sm:inline-block" wire:poll.30s>
    @foreach ($activities as $activity)
        <x-users.activity-item :$activity />
    @endforeach
</x-scrollable-wrapper>
