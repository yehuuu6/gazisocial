<div>
    <section class="bg-white rounded-xl shadow-md border p-10 border-gray-100">
        <div class="text-center">
            <h3 class="text-3xl font-semibold text-gray-900">Dev Center</h3>
            <p class="mt-1.5 text-gray-600 text-lg font-normal mx-20">
                Welcome to the development center of the Gazi Social. Here you can find all the information you need
                to contribute to
                the project.
            </p>
        </div>
        <div class="mt-12 grid gap-5 grid-cols-2 text-center">
            <div
                class="hover:shadow-md border border-gray-200 shadow rounded-md bg-white transition duration-200 flex flex-col items-center justify-center gap-4 px-3 py-8">
                <div class="rounded-full bg-blue-50 p-2 text-blue-400">
                    <x-icons.github size="36" />
                </div>
                <span class="text-lg font-normal text-gray-800">GitHub Repository</span>
                <p class="text-base font-light text-gray-600">
                    View the project's source code and contribute to the development
                </p>
                <a target="_blank" href="https://github.com/yehuuu6/gazisocial"
                    class="text-gray-700 px-5 py-2.5 text-center text-sm mt-2 font-medium bg-white rounded-md border transition duration-300 border-gray-200 hover:bg-gray-100 hover:no-underline">
                    Star on GitHub
                </a>
            </div>
            <div
                class="hover:shadow-md border border-gray-200 shadow rounded-md bg-white transition duration-200 flex flex-col items-center justify-center gap-4 px-3 py-8">
                <div class="rounded-full bg-blue-50 p-2 text-blue-400">
                    <x-icons.code size="36" />
                </div>
                <span class="text-lg font-normal text-gray-800">How to Contribute?</span>
                <p class="text-base font-light text-gray-600">
                    Learn how to contribute to the project and make your first contribution
                </p>
                <x-link href="{{ route('how-to-contribute') }}"
                    class="text-gray-700 px-5 py-2.5 text-center text-sm mt-2 font-medium bg-white rounded-md border transition duration-300 border-gray-200 hover:bg-gray-100 hover:no-underline">
                    Contribution Guide
                </x-link>
            </div>
            <div
                class="hover:shadow-md border border-gray-200 shadow rounded-md bg-white transition duration-200 flex flex-col items-center justify-center gap-4 px-3 py-8">
                <div class="rounded-full bg-blue-50 p-2 text-blue-400">
                    <x-icons.bug size="36" />
                </div>
                <span class="text-lg font-normal text-gray-800">Bug Reports</span>
                <p class="text-base font-light text-gray-600">
                    Report any bugs you encounter while using the project, or try to fix them yourself
                </p>
                <x-link href="{{ route('reported-bugs') }}"
                    class="text-gray-700 px-5 py-2.5 text-center text-sm mt-2 font-medium bg-white rounded-md border transition duration-300 border-gray-200 hover:bg-gray-100 hover:no-underline">
                    Reported Bugs
                </x-link>
            </div>
            <div
                class="hover:shadow-md border border-gray-200 shadow rounded-md bg-white transition duration-200 flex flex-col items-center justify-center gap-4 px-3 py-8">
                <div class="rounded-full bg-blue-50 p-2 text-blue-400">
                    <x-icons.heart size="36" />
                </div>
                <span class="text-lg font-normal text-gray-800">Contributors</span>
                <p class="text-base font-light text-gray-600">
                    View all the contributors who have contributed to the project, and join them if you want
                </p>
                <x-link href="{{ route('contributors') }}"
                    class="text-gray-700 px-5 py-2.5 text-center text-sm mt-2 font-medium bg-white rounded-md border transition duration-300 border-gray-200 hover:bg-gray-100 hover:no-underline">
                    See Contributors
                </x-link>
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
