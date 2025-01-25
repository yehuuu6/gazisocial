<div>
    <section class="bg-white rounded-xl shadow-md border p-6 md:p-10 border-gray-100">
        <div class="text-center">
            <h3
                class="text-6xl font-extrabold bg-gradient-to-bl from-sky-300 to-blue-800 bg-clip-text text-transparent leading-normal">
                Dev Center
            </h3>
            <p class="mt-1.5 text-gray-700 text-base md:text-lg font-semibold mx-5 md:mx-80">
                Welcome to the development center of the Gazi Social. Here you can find all the information you need
                to contribute to
                the project.
            </p>
        </div>
        <div class="mt-6 md:mt-12 grid gap-5 md:grid-cols-2 text-center grid-cols-1 md:mx-28">
            <x-dev-center.introduction-card bgClass="bg-gradient-to-br from-blue-200 to-sky-100">
                <x-slot name="icon">
                    <x-icons.github size="36" />
                </x-slot>
                <x-slot name="title">
                    GitHub Repository
                </x-slot>
                <x-slot name="description">
                    View the project's source code and contribute to the development
                </x-slot>
                <x-slot name="button">
                    <a target="_blank" href="https://github.com/yehuuu6/gazisocial"
                        class="text-white px-4 md:px-5 py-2.5 text-center text-xs md:text-sm mt-2 font-medium bg-blue-400 rounded-md transition duration-300 hover:bg-blue-500 hover:no-underline">
                        Star on GitHub
                    </a>
                </x-slot>
            </x-dev-center.introduction-card>
            <x-dev-center.introduction-card bgClass="bg-gradient-to-bl from-blue-200 to-sky-100">
                <x-slot name="icon">
                    <x-icons.code size="36" />
                </x-slot>
                <x-slot name="title">
                    How to Contribute?
                </x-slot>
                <x-slot name="description">
                    Learn how to contribute to the project and make your first contribution
                </x-slot>
                <x-slot name="button">
                    <x-link href="{{ route('how-to-contribute') }}"
                        class="text-white px-4 md:px-5 py-2.5 text-center text-xs md:text-sm mt-2 font-medium bg-blue-400 rounded-md transition duration-300 hover:bg-blue-500 hover:no-underline">
                        Contribution Guide
                    </x-link>
                </x-slot>
            </x-dev-center.introduction-card>
            <x-dev-center.introduction-card bgClass="bg-gradient-to-tr from-blue-200 to-sky-100">
                <x-slot name="icon">
                    <x-icons.bug size="36" />
                </x-slot>
                <x-slot name="title">
                    Bug Reports
                </x-slot>
                <x-slot name="description">
                    Report any bugs you encounter while using the project, or try to fix them yourself
                </x-slot>
                <x-slot name="button">
                    <x-link href="{{ route('reported-bugs') }}"
                        class="text-white px-4 md:px-5 py-2.5 text-center text-xs md:text-sm mt-2 font-medium bg-blue-400 rounded-md transition duration-300 hover:bg-blue-500 hover:no-underline">
                        Reported Bugs
                    </x-link>
                </x-slot>
            </x-dev-center.introduction-card>
            <x-dev-center.introduction-card bgClass="bg-gradient-to-tl from-blue-200 to-sky-100">
                <x-slot name="icon">
                    <x-icons.heart size="36" />
                </x-slot>
                <x-slot name="title">
                    Contributors
                </x-slot>
                <x-slot name="description">
                    View all the contributors who have contributed to the project, and join them if you want
                </x-slot>
                <x-slot name="button">
                    <x-link href="{{ route('contributors') }}"
                        class="text-white px-4 md:px-5 py-2.5 text-center text-xs md:text-sm mt-2 font-medium bg-blue-400 rounded-md transition duration-300 hover:bg-blue-500 hover:no-underline">
                        See Contributors
                    </x-link>
                </x-slot>
            </x-dev-center.introduction-card>
        </div>
        <div class="text-center mt-10">
            <h3
                class="text-4xl font-extrabold bg-gradient-to-bl from-sky-300 to-blue-800 bg-clip-text text-transparent leading-normal">
                Tech Stack
            </h3>
            <p class="mt-1.5 text-gray-700 text-base md:text-base font-medium mx-5 md:mx-80">Gazi Social is built using
                the following technologies, for more info visit <a href="https://tallstack.dev/" target="_blank"
                    class="text-blue-400 hover:underline">TALL stack</a> page.
            </p>
            <div x-data x-init="$nextTick(() => {
                const content = $refs.content;
                const item = $refs.item;
                const clone = item.cloneNode(true);
                content.appendChild(clone);
            });" class="relative w-full mt-6 bg-white container-block">
                <div
                    class="relative w-full py-3 mx-auto overflow-hidden text-lg italic tracking-wide text-white uppercase bg-white max-w-7xl sm:text-xs md:text-sm lg:text-base xl:text-xl 2xl:text-2xl">
                    <div class="absolute left-0 z-20 w-40 h-full bg-gradient-to-r from-white to-transparent"></div>
                    <div class="absolute right-0 z-20 w-40 h-full bg-gradient-to-l from-white to-transparent"></div>
                    <div x-ref="content" class="flex animate-marquee">
                        <div x-ref="item"
                            class="flex items-center justify-around flex-shrink-0 w-full py-2 gap-2 text-white">
                            <div class="w-[200px]">
                                <img src="{{ asset('marquee/alpine.webp') }}" alt="Laravel Framework"
                                    class="w-full h-auto object-contain">
                            </div>
                            <div class="w-[200px]">
                                <img src="{{ asset('marquee/laravel.png') }}" alt="Laravel Framework"
                                    class="w-full h-auto object-contain">
                            </div>
                            <div class="w-[200px]">
                                <img src="{{ asset('marquee/livewire.png') }}" alt="Laravel Framework"
                                    class="w-full h-auto object-contain">
                            </div>
                            <div class="w-[200px]">
                                <img src="{{ asset('marquee/tailwind.png') }}" alt="Laravel Framework"
                                    class="w-full h-auto object-contain">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-12 text-center">
            <p class="text-sm text-gray-700 font-light">
                This project is licensed under the <a target="_blank"
                    href="https://www.gnu.org/licenses/gpl-3.0.en.html" class="hover:underline italic">GNU General
                    Public License v3.0</a>.
            </p>
        </div>
    </section>
</div>
