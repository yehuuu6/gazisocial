<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('canonical')
    @livewireStyles
    @stack('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Sosyalleşmenin yeni adresi - Gazi Social' }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body class="min-h-svh flex flex-col w-full bg-slate-100 font-inter antialiased">
    <x-layout.navbar />
    <x-layout.header />
    <main class="mx-[3%] mt-4 md:mx-[6%] md:mt-8 mb-7 md:mb-14 lg:mx-[12%]">
        {{ $slot }}
    </main>
    <x-layout.footer />
    @persist('toaster')
        <x-toaster-hub />
    @endpersist
    @livewireScriptConfig
</body>

</html>
