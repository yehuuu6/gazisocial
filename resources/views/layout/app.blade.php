<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @yield('canonical')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Sosyalleşmenin yeni adresi - Gazi Social' }}</title>
</head>

<body class="antialiased w-full min-h-dvh bg-gray-100 font-inter overflow-x-hidden">
    <livewire:components.navbar />
    <x-header />
    <main class="mx-[3%] md:mx-[6%] lg:mx-[12%] mt-4 md:mt-8">
        {{ $slot }}
    </main>
    <x-footer />
    @livewire('wire-elements-modal')
</body>

</html>
