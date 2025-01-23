<div class="shadow-md bg-white border border-gray-100 rounded-xl overflow-hidden">
    <div class="m-6">
        <h1 class="text-3xl font-bold text-gray-900">Contributors</h1>
        <p class="text-gray-500 text-base">Thanks to all the contributors who have helped to make this project possible.
        </p>
    </div>
    <div>
        <div class="flex gap-2 flex-wrap m-6">
            <x-contributor avatar="{{ asset('gazi-logo.png') }}" name="Eren Aydın" username="yehuuu6"
                role="Creator of Gazi Social" />
            <x-contributor avatar="{{ asset('gazi-logo.png') }}" name="Melek Selihan Güleç" username="melekisnotthere"
                role="Contributor" />
        </div>
        <p class="mx-6 text-sm text-gray-400">
            Want to showcase your name here? <x-link href="{{ route('how-to-contribute') }} "
                class="text-blue-400">Contribution Guide</x-link> will help you.
        </p>
    </div>
    <div class="m-6">
        <h1 class="text-xl font-medium text-gray-700">Tech Stack</h1>
        <p class="text-gray-500 text-base">Gazi Social is built using the following technologies, for more info visit <a
                href="https://tallstack.dev/" target="_blank" class="text-cyan-500 hover:underline">TALL stack</a> page.
        </p>
    </div>
    <div x-data x-init="$nextTick(() => {
        const content = $refs.content;
        const item = $refs.item;
        const clone = item.cloneNode(true);
        content.appendChild(clone);
    });" class="relative w-full bg-gray-50 container-block">
        <div
            class="relative w-full py-3 mx-auto overflow-hidden text-lg italic tracking-wide text-white uppercase bg-gray-50 max-w-7xl sm:text-xs md:text-sm lg:text-base xl:text-xl 2xl:text-2xl">
            <div class="absolute left-0 z-20 w-40 h-full bg-gradient-to-r from-gray-50 to-transparent"></div>
            <div class="absolute right-0 z-20 w-40 h-full bg-gradient-to-l from-gray-50 to-transparent"></div>
            <div x-ref="content" class="flex animate-marquee">
                <div x-ref="item"
                    class="flex items-center justify-around flex-shrink-0 w-full py-2 space-x-4 text-white">
                    <div class="w-[175px]">
                        <img src="{{ asset('marquee/alpine.webp') }}" alt="Laravel Framework"
                            class="w-full h-auto object-contain">
                    </div>
                    <div class="w-[175px]">
                        <img src="{{ asset('marquee/laravel.png') }}" alt="Laravel Framework"
                            class="w-full h-auto object-contain">
                    </div>
                    <div class="w-[175px]">
                        <img src="{{ asset('marquee/livewire.png') }}" alt="Laravel Framework"
                            class="w-full h-auto object-contain">
                    </div>
                    <div class="w-[175px]">
                        <img src="{{ asset('marquee/tailwind.png') }}" alt="Laravel Framework"
                            class="w-full h-auto object-contain">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="m-6">
        <h1 class="text-xl font-medium text-gray-700">Fundings</h1>
        <p class="text-gray-500 text-base">Gazi Social is an open-source project maintained by university students and
            community
            members. We would gladly accept sponsorships to help us maintain and host the forum.</p>
    </div>
</div>
