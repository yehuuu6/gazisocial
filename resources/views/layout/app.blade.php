<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Gazi Üniversitesi öğrencileri için sosyalleşme platformu. Kampüs hayatınızı zenginleştirin, etkinlikleri keşfedin ve yeni arkadaşlar edinin.')">
    <meta name="keywords" content="@yield('keywords', 'Gazi Üniversitesi, sosyal platform, öğrenci topluluğu, kampüs hayatı, Gazi Social, üniversite forumu, gazisocial, gazi social')">
    <meta name="author" content="Gazi Social">
    <meta name="robots" content="index, follow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('canonical')
    @livewireStyles
    @stack('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Open Graph / Facebook -->
    <meta property="og:site_name" content="Gazi Social">
    <meta property="og:title" content="@yield('title', $title ?? 'Sosyalleşmenin yeni adresi - Gazi Social')">
    <meta property="og:description" content="@yield('description', 'Gazi Üniversitesi öğrencileri için sosyalleşme platformu. Kampüs hayatınızı zenginleştirin ve arkadaşlar edinin.')">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="tr">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('image', asset('logos/GS_LOGO_DEFAULT.png'))" itemprop="image">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Sosyalleşmenin yeni adresi - Gazi Social">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $title ?? 'Sosyalleşmenin yeni adresi - Gazi Social')">
    <meta name="twitter:description" content="@yield('description', 'Gazi Üniversitesi öğrencileri için sosyalleşme platformu.')">
    <meta name="twitter:image" content="@yield('image', asset('logos/GS_LOGO_DEFAULT.png'))">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <title>{{ $title ?? 'Sosyalleşmenin yeni adresi - Gazi Social' }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon-16x16.png') }}">
</head>

<body class="min-h-svh flex flex-col w-full bg-slate-100 font-inter antialiased">
    <x-layout.navbar />
    <x-layout.header />
    <main class="mx-[3%] mt-4 xl:mx-[6%] md:mt-8 mb-7 md:mb-14 2xl:mx-[12%]">
        @auth
            @if (Auth::user()->is_banned)
                <x-ban-info />
            @elseif (Auth::user()->email_verified_at == null)
                <x-email-not-verified />
            @elseif (!Auth::user()->canDoHighLevelAction() && !Auth::user()->isStudent() && Auth::user()->isNewAccount())
                <x-new-account-warning />
            @endif
        @endauth
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
