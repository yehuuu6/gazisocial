<div class="shadow-md bg-white border border-gray-100 rounded-xl overflow-hidden">
    <div class="m-6">
        <h1 class="text-3xl font-bold text-gray-900">Contributors</h1>
        <p class="text-gray-500 text-base">Thanks to all the contributors who have helped to make this project possible.
        </p>
    </div>
    <div class="m-6">
        <div class="flex gap-2 flex-wrap">
            <x-contributor avatar="{{ asset('gazi-logo.png') }}" name="Eren Aydın" username="yehuuu6"
                role="Creator of Gazi Social" />
            <x-contributor avatar="{{ asset('gazi-logo.png') }}" name="Melek Selihan Güleç" username="melekisnotthere"
                role="Contributor" />
        </div>
        <p class="mt-3.5 text-sm text-gray-400">
            Want to showcase your name here? <x-link href="{{ route('how-to-contribute') }} "
                class="text-blue-400">Contribution Guide</x-link> will help you.
        </p>
    </div>
</div>
