<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Gazi Social' }}</title>
</head>

<body class="antialiased h-screen flex flex-col bg-gray-100">
    <livewire:components.navbar />
    <main class="flex-1">
        {{ $slot }}
    </main>
    <footer class="bg-gray-800 text-white p-4 font-medium flex justify-between items-center">
        <h4>Copyright all rights reserved.</h4>
        <h4>© 2024 Gazi Social</h4>
    </footer>
</body>

</html>
