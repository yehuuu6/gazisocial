<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('canonical')
    @livewireStyles
    @stack('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Oyun Merkezi - Gazi Social' }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body x-data="{
    fullscreen: false,
}"
    class="min-h-screen flex flex-col w-full overflow-x-hidden bg-slate-100 font-inter antialiased">
    <div x-show="!fullscreen">
        <x-layout.navbar />
    </div>
    <main
        :class="{
            'h-screen': fullscreen,
            'mx-[2%] mt-4 md:mx-[4%] h-auto md:mt-8 mb-7 md:mb-14 lg:mx-[8%]': !fullscreen,
        }"
        class="mx-[2%] mt-4 md:mx-[4%] h-auto md:mt-8 mb-7 md:mb-14 lg:mx-[8%]">
        {{ $slot }}
    </main>
    <div class="mt-auto" x-show="!fullscreen">
        <x-layout.footer />
    </div>
    @persist('toaster')
        <x-toaster-hub />
    @endpersist
    @livewireScriptConfig
</body>

</html>
