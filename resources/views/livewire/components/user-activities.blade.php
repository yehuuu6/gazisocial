<div class="relative h-1/2" wire:poll.15s>
    <ul class="bg-white overflow-y-auto divide-y divide-gray-300 absolute h-full w-full scrollbar-track-gray-100">
        @foreach ($activities as $activity)
            <x-users.activity-item :$activity />
        @endforeach
    </ul>
</div>
