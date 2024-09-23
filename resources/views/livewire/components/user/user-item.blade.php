<tr>
    <td class="p-4 text-left">
        <div class="flex items-center gap-2">
            <x-link class="hidden md:block" title="{{ $user->name }}" href="{{ route('users.show', $user->username) }}">
                <img class="size-8 md:size-10 rounded-full" src="{{ $user->avatar }}" alt="avatar">
            </x-link>
            <div class="flex flex-col gap-0">
                <x-link href="{{ route('users.show', $user->username) }}"
                    class="text-sm md:text-base lg:text-lg hover:no-underline text-gray-700 font-medium hover:opacity-85 transition-all duration-300">
                    {{ $user->name }}
                </x-link>
                <span class="text-xs md:text-sm text-gray-400">{{ '@' . $user->username }}</span>
            </div>
        </div>
    </td>
    <td class="p-4 text-center text-xs md:text-sm font-semibold text-gray-400">
        <div class="flex flex-wrap items-center justify-center gap-2">
            @forelse ($user->roles as $role)
                <span
                    class="py-1 px-2 {{ $colorVariants[$role->color] }} text-white font-medium rounded-full capitalize text-xs">{{ $role->name }}</span>
            @empty
                <span class="py-1 px-2 bg-orange-500 text-white font-medium rounded-full capitalize text-xs">Üye</span>
            @endforelse
        </div>
    </td>
    <td class="p-4 hidden md:table-cell text-center text-xs md:text-sm text-gray-400">
        {{ $user->last_activity->locale('tr')->diffForHumans() }}
    </td>
    <td class="p-4 md:hidden text-center text-xs md:text-sm text-gray-400">
        {{ $user->last_activity->locale('tr')->shortAbsoluteDiffForHumans() }}
    </td>
</tr>
