<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="@yield('description', 'Gazi Social hesabınıza giriş yapın veya yeni bir hesap oluşturun. Gazi Üniversitesi öğrencileri için özel sosyal platform.')">
        <meta name="keywords" content="Gazi Üniversitesi, öğrenci girişi, hesap oluşturma, sosyal platform, kayıt, giriş">
        <meta name="author" content="Gazi Social">
        <meta name="robots" content="index, follow">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
        @livewireStyles
        <title>{{ $title }} - {{ config('app.name') }}</title>
        <!-- Open Graph / Facebook -->
        <meta property="og:site_name" content="Gazi Social">
        <meta property="og:title" content="Gazi Social - {{ $title }}">
        <meta property="og:description" content="@yield('description', 'Gazi Üniversitesi öğrencileri için sosyalleşme platformu. Hesabınıza giriş yapın veya yeni hesap oluşturun.')">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="tr">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ asset('logos/GS_LOGO_DEFAULT.png') }}" itemprop="image">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="Sosyalleşmenin yeni adresi - Gazi Social">
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Gazi Social - {{ $title }}">
        <meta name="twitter:description" content="@yield('description', 'Gazi Üniversitesi öğrencileri için sosyalleşme platformu. Hesabınıza giriş yapın.')">
        <meta name="twitter:image" content="{{ asset('logos/GS_LOGO_DEFAULT.png') }}">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <script src="https://www.google.com/recaptcha/api.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="min-h-svh w-full bg-white font-inter antialiased">
        {{ $slot }}
        <x-toaster-hub />
        @livewireScriptConfig
    </body>

</html>
