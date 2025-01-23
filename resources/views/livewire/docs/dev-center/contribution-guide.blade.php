<div class="bg-white overflow-hidden shadow-md rounded-xl border border-gray-100">
    <div class="m-6 mb-0 flex flex-col gap-3">
        <div
            class="py-2 px-4 flex gap-2.5 items-center rounded-md border border-orange-200 bg-orange-50 text-orange-400 text-sm font-normal self-start">
            <div>
                <x-icons.info size="18" class="size-8 md:size-5" />
            </div>
            <span>
                This guide might get updated in the future. Please check back regularly. Last updated on 29 November
                2024
            </span>
        </div>
        @if ($os !== 'Windows')
            <div
                class="py-2 px-4 flex gap-2.5 items-center rounded-md border border-orange-200 bg-orange-50 text-orange-400 text-sm font-normal self-start">
                <div>
                    <x-icons.info size="18" class="size-8 md:size-5" />
                </div>
                <span>
                    This guide was created for Windows users. Some tools recommended here may not be available for
                    Linux or Mac users.
                </span>
            </div>
        @endif
    </div>
    <div class="m-6">
        <h1 class="text-3xl font-bold text-gray-900">Contribution Guide</h1>
        <p class="mt-1 text-base text-gray-500">Learn how to contribute to the development of Gazi Social and
            get your name on the <x-link href="{{ route('contributors') }}" class="text-blue-400">Contributors</x-link>
            list.</p>
    </div>

    <div class="m-6">
        <h2 class="text-xl font-medium text-gray-700">1. Basic rules</h2>
        <p class="mt-1 text-base text-gray-500">Before contributing to the project, please read the following rules:</p>
        <ul class="mt-2 ml-4 text-base text-gray-500 list-disc list-inside">
            <li>You must have some knowledge of the <a href="https://tallstack.dev/"
                    class="text-blue-400 hover:underline" target="_blank">TALL
                    stack</a>. (Tailwind CSS, Alpine JS, Laravel and Livewire)</li>
            <li>All contributions must be made in English.</li>
            <li>If you are a beginner with the TALL stack, then just try to fix minor bugs & typos. One step at a time.
            </li>
            <li>Do not submit any changes that are not related to the project.</li>
            <li>You must describe what you have changed and why you have changed it in the pull request.</li>
        </ul>
    </div>
    <div class="m-6">
        <h2 class="text-xl font-medium text-gray-700">2. Downloading necessary tools</h2>
        <p class="mt-2 text-base text-gray-500">You need to download some tools to your Mac or PC in order to be able to
            develop Laravel applications with ease.</p>
        <p class="mt-2 text-base text-gray-500">Here is the list of the tools I use. These all completely optional if
            you have another way of developing Laravel applications.</p>
        <ul class="mt-2 ml-4 text-base text-gray-500 list-disc list-inside">
            <li><a href="https://code.visualstudio.com/" class="text-blue-400 hover:underline" target="_blank">Visual
                    Studio Code</a> - A lightweight code editor with support of many extensions.</li>
            <li><a href="https://herd.laravel.com/" class="text-blue-400 hover:underline" target="_blank">Laravel
                    Herd</a> - Herd downloads all the necessary things like
                php, npm and composer for you. Plus it gives you a chance to serve your project locally.</li>
            <li><a href="https://www.mysql.com/" class="text-blue-400 hover:underline" target="_blank">MySQL</a> -
                Laravel Herd is paid software, but you can manually install tools like MySQL to avoid paying for Herd
                Pro. If affordable, Herd Pro simplifies this by including these tools..</li>
            <li><a href="https://tableplus.com/" class="text-blue-400 hover:underline" target="_blank">Table Plus</a> -
                A database management tool. You can view the tables of your database and make changes on them using
                this. It's a paid software aswell but free version is more than enough.</li>
        </ul>
    </div>
    <div class="m-6">
        <h2 class="text-xl font-medium text-gray-700">3. Forking and cloning repositories</h2>
        <p class="mt-1 text-base text-gray-500">
            To get started, the first step is to fork and clone the repositories. The easiest way to do this is by using
            the GitHub CLI, but you can also perform these steps manually by clicking the "Fork" button on the <a
                href="https://github.com/yehuuu6/gazisocial" class="text-blue-400 hover:underline"
                target="_blank">GitHub
                repository page</a>.
        </p>
    </div>
    <div class="m-6">
        <h2 class="text-xl font-medium text-gray-700">4. Setting up the project</h2>
        <p class="mt-2 text-base text-gray-500">Once the cloning process is complete, you need to install the project's
            dependencies. You can do this by running the following commands:</p>
        <div class="p-2 md:p-4 bg-gray-50 rounded-md">
            <pre class="text-sm text-purple-500 whitespace-pre-line break-all">
                <code>cd gazisocial</code>
                <code>composer install</code>
                <code>npm install</code>
            </pre>
        </div>
        <p class="mt-2 text-base text-gray-500">After installing the dependencies, you need to create your own .env
            file. You can use the .env.example file to copy and fill the blanks.</p>
        <p class="mt-2 text-base text-gray-500">You need to generate an application key by running the following
            command:</p>
        <div class="p-2 md:p-4 bg-gray-50 rounded-md">
            <pre class="text-sm text-purple-500 whitespace-pre-line break-all">
                <code>php artisan key:generate</code>
            </pre>
        </div>
        <p class="mt-2 text-base text-gray-500">After that, you need to set up <a target="_blank"
                class="text-blue-400 hover:underline" href="https://mailtrap.io/">Mailtrap</a> and <a target="_blank"
                class="text-blue-400 hover:underline" href="https://reverb.laravel.com/">Laravel Reverb</a> fields in
            the
            .env file.</p>
    </div>
    <div class="m-6">
        <h2 class="text-xl font-medium text-gray-700">Launching dev server</h2>
        <p class="mt-1 text-base text-gray-500">Once everything is ready, you can start the dev server by running the
            Laravel Herd</p>
        <p class="mt-2 text-base text-gray-500">And then you can execute this command to start queue worker, reverb
            server and vite:</p>
        <div class="p-2 md:p-4 bg-gray-50 rounded-md">
            <pre class="text-sm text-purple-500 whitespace-pre-line break-all">
                <code>composer run dev</code>
            </pre>
        </div>
        <p class="mt-2 text-base text-gray-500">After running the command, you can access the forum by visiting <a
                href="http://gazisocial.test" class="text-blue-400 hover:underline"
                target="_blank">http://gazisocial.test</a>
        </p>
    </div>
    <div class="m-6">
        <h2 class="text-xl font-medium text-gray-700">Migrating and seeding the database</h2>
        <p class="mt-1 text-base text-gray-500">If everything is correct, you can now run the migrations and seed the
            database.</p>
        <div class="p-2 md:p-4 bg-gray-50 rounded-md">
            <pre class="text-sm text-purple-500 whitespace-pre-line break-all">
                <code>php artisan migrate:fresh --seed</code>
                <code>php artisan db:seed --class=FacultySeeder</code>
                <code>php artisan db:seed --class=ContactMessagesSeeder</code>
            </pre>
        </div>
        <p class="mt-2 text-base text-gray-500">Seeding process may take a while. Please be patient.</p>
    </div>
    <div class="m-6">
        <h2 class="text-xl font-medium text-gray-700">Creating a new branch</h2>
        <p class="mt-1 text-base text-gray-500">Before making changes to the project, you need to create a new branch.
            You can do this by running the following command:</p>
        <div class="p-2 md:p-4 bg-gray-50 rounded-md">
            <pre class="text-sm text-purple-500 whitespace-pre-line break-all">
                <code>git checkout -b fix-bug</code>
            </pre>
        </div>
    </div>
    <div class="m-6">
        <h2 class="text-xl font-medium text-gray-700">Creating a pull request</h2>
        <p class="mt-1 text-base text-gray-500">When you are done with implementing your changes, you need to create a
            pull request. You can do this by running the following command:</p>
        <div class="p-2 md:p-4 bg-gray-50 rounded-md">
            <pre class="text-sm text-purple-500 whitespace-pre-line break-all">
                <code>git push origin fix-bug</code>
            </pre>
        </div>
        <p class="mt-1 text-base text-gray-500">Open your forked repository
            (<code>https://github.com/&lt;your-username&gt;/gazisocial</code>). You will see a new notification:
            "<strong>fix-bug had recent pushes 1 minute ago</strong>" along with a button that
            says "<strong>Compare &amp; pull request</strong>." Click the button to open the pull request form.</p>
        <div class="mt-2 p-2 md:p-4 bg-gray-50 rounded-md">
            <pre class="text-sm text-purple-500 whitespace-pre-line break-all">
                <code>
                    Review the contribution guide first at: https://gazisocial.com/dev-center/contribution-guide
 
                    1️⃣ Was this a reported bug or feature request?
                    Yes, you can find the issue here: https://github.com/yehuuu6/gazisocial/issues/999999
                    or
                    Yes, you can find the bug report here: https://gazisocial.test/dev-center/reported-bug/999999
                    
                    2️⃣ Did you create a branch for your fix/feature? (Main branch PR's will be closed)
                    Yes, the branch is named `fix-bug`
                    
                    3️⃣ Does it contain multiple, unrelated changes? Please separate the PRs out.
                    No, the changes are only related to my feature.

                    4️⃣ Please include a short but useful description of the changes you have made.
                    
                    These changes will fix the bug mentioned in the bug report.
                    
                    // ...
                </code>
            </pre>
        </div>
        <p class="mt-1 text-base text-gray-500">
            Fill out the form with the necessary information and click the "Create pull request" button. Now you just
            have to wait for yout pull request to be reviewed. If everything is ok, your PR will be merged.
        </p>
    </div>
    <div class="m-6">
        <h2 class="text-xl font-medium text-gray-700">Congratulations!</h2>
        <p class="mt-1 text-base text-gray-500">Thank you for helping us improve Gazi Social!
        </p>
    </div>
</div>
