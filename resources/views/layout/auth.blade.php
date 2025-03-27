<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @livewireStyles
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <meta property="og:site_name" content="Gazi Social">
    <meta property="og:title" content="Gazi Social - {{ $title }}">
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-svh w-full bg-white font-inter antialiased">
    {{ $slot }}
    <x-toaster-hub />
    @livewireScriptConfig
</body>

</html>
