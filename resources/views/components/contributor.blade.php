@props(['avatar', 'name', 'username', 'role'])

<div class="flex gap-3 max-w-sm justify-between p-4 border border-gray-200 shadow-sm rounded-md">
    <div class="w-10 h-10 rounded-full overflow-hidden">
        <img src="{{ $avatar }}" alt="{{ $name }}" class="w-full h-full object-cover">
    </div>
    <div class="flex flex-col gap-0.5 mr-8">
        <span class="text-gray-900 text-sm font-medium">{{ $name }}</span>
        <span class="text-gray-500 text-sm font-normal">{{ $username }}</span>
    </div>
    <x-ui.tooltip text="{{ $role }}">
        <x-icons.trophy size="20" class="text-yellow-400" />
    </x-ui.tooltip>
</div>
