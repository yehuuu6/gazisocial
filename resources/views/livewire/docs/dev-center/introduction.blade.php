<div>
    <section class="bg-white rounded-xl shadow-md border p-6 md:p-10 border-gray-100">
        <div class="text-center">
            <h3 class="text-xl md:text-3xl font-semibold text-gray-900">Dev Center</h3>
            <p class="mt-1.5 text-gray-600 text-sm md:text-lg font-normal mx-5 md:mx-20">
                Welcome to the development center of the Gazi Social. Here you can find all the information you need
                to contribute to
                the project.
            </p>
        </div>
        <div class="mt-6 md:mt-12 grid gap-5 md:grid-cols-2 text-center grid-cols-1">
            <x-dev-center.introduction-card>
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
                        class="text-gray-700 px-4 md:px-5 py-2.5 text-center text-xs md:text-sm mt-2 font-medium bg-white rounded-md border transition duration-300 border-gray-200 hover:bg-gray-100 hover:no-underline">
                        Star on GitHub
                    </a>
                </x-slot>
            </x-dev-center.introduction-card>
            <x-dev-center.introduction-card>
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
                        class="text-gray-700 px-4 md:px-5 py-2.5 text-center text-xs md:text-sm mt-2 font-medium bg-white rounded-md border transition duration-300 border-gray-200 hover:bg-gray-100 hover:no-underline">
                        Contribution Guide
                    </x-link>
                </x-slot>
            </x-dev-center.introduction-card>
            <x-dev-center.introduction-card>
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
                        class="text-gray-700 px-4 md:px-5 py-2.5 text-center text-xs md:text-sm mt-2 font-medium bg-white rounded-md border transition duration-300 border-gray-200 hover:bg-gray-100 hover:no-underline">
                        Reported Bugs
                    </x-link>
                </x-slot>
            </x-dev-center.introduction-card>
            <x-dev-center.introduction-card>
                <x-slot name="icon">
                    <x-icons.bug size="36" />
                </x-slot>
                <x-slot name="title">
                    Contributors
                </x-slot>
                <x-slot name="description">
                    View all the contributors who have contributed to the project, and join them if you want
                </x-slot>
                <x-slot name="button">
                    <x-link href="{{ route('contributors') }}"
                        class="text-gray-700 px-4 md:px-5 py-2.5 text-center text-xs md:text-sm mt-2 font-medium bg-white rounded-md border transition duration-300 border-gray-200 hover:bg-gray-100 hover:no-underline">
                        See Contributors
                    </x-link>
                </x-slot>
            </x-dev-center.introduction-card>
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
