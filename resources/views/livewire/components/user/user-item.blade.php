<tr>
    <td class="p-4 text-left">
        <div class="flex items-center gap-2">
            <x-link class="hidden md:block" title="{{ $user->name }}" href="{{ route('user.show', $user->username) }}">
                <img class="size-8 md:size-10 rounded-full" src="{{ $user->avatar }}" alt="avatar">
            </x-link>
            <div class="flex flex-col gap-2 md:gap-0">
                <div class="flex flex-wrap item-center gap-2">
                    @foreach ($user->roles as $role)
                        <span
                            class="py-1 px-2 {{ $colorVariants[$role->color] }} text-white font-medium rounded-full capitalize text-xs">{{ $role->name }}</span>
                    @endforeach
                </div>
                <x-link href="{{ route('user.show', $user->username) }}"
                    class="text-sm md:text-base lg:text-lg hover:no-underline text-gray-700 font-medium hover:opacity-85 transition-all duration-300">
                    {{ $user->name }}
                </x-link>
            </div>
        </div>
    </td>
    <td class="p-4 text-center text-xs md:text-sm font-semibold text-gray-400">
        1
    </td>
    <td class="p-4 hidden md:table-cell text-center text-xs md:text-sm text-gray-400">
        2
    </td>
    <td class="p-4 hidden md:table-cell text-center text-xs md:text-sm text-gray-400">
        {{ $user->created_at->locale('tr')->diffForHumans() }}
    </td>
    <td class="p-4 md:hidden text-center text-xs md:text-sm text-gray-400">
        {{ $user->created_at->locale('tr')->shortAbsoluteDiffForHumans() }}
    </td>
</tr>
