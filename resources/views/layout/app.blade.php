<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Sosyalleşmenin yeni adresi - Gazi Social' }}</title>
</head>

<body class="antialiased h-screen flex flex-col bg-gray-100 overflow-hidden">
    <livewire:components.navbar />
    <main class="flex-1">
        <div class="h-full flex-1 grid grid-cols-1 md:grid-cols-[320px_1fr] gap-6 p-6">
            <div class="bg-white shadow-md rounded-xl hidden flex-col overflow-hidden md:flex">
                <h3 class="text-xl font-bold p-4">Kategoriler ve Aktiviteler</h3>
                <x-seperator />
                <livewire:components.categories lazy />
                <x-seperator />
                <livewire:components.user-activities lazy />
            </div>
            {{ $slot }}
        </div>
    </main>
    <footer class="bg-gray-800 text-white p-2 md:p-4 font-medium flex justify-between items-center">
        <h4 class="text-sm md:text-base">Copyright all rights reserved.</h4>
        <h4 class="text-sm md:text-base">© 2024 Gazi Social</h4>
    </footer>
    @livewire('wire-elements-modal')
</body>

</html>
