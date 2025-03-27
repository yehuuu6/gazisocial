<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('canonical')
    @livewireStyles
    @stack('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta property="og:site_name" content="Gazi Social">
    <meta property="og:title" content="Gazi Social">
    <meta property="og:description" content="Gazi Üniversitesi öğrencileri için sosyalleşme platformu.">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="tr">
    <meta property="og:url" content="https://gazisocial.com/">
    <meta property="og:image" content="{{ asset('logos/GS_LOGO_DEFAULT.png') }}" itemprop="image">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Sosyalleşmenin yeni adresi - Gazi Social">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Gazi Social">
    <meta name="twitter:image" content="{{ asset('logos/GS_LOGO_DEFAULT.png') }}">
    @yield('ogtags')
    <title>{{ $title ?? 'Sosyalleşmenin yeni adresi - Gazi Social' }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>

<body class="min-h-svh flex flex-col w-full bg-slate-100 font-inter antialiased">
    <x-layout.navbar />
    <x-layout.header />
    <main class="mx-[3%] mt-4 xl:mx-[6%] md:mt-8 mb-7 md:mb-14 2xl:mx-[12%]">
        {{ $slot }}
    </main>
    <x-layout.footer />
    @persist('toaster')
        <x-cookie-banner />
        <x-toaster-hub />
    @endpersist
    @livewireScriptConfig
</body>

</html>
