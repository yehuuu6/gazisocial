<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:site_name" content="Gazi Social - Oyun Merkezi">
    <meta property="og:title" content="Gazi Social">
    <meta property="og:description" content="Gazi Üniversitesi öğrencileri için sosyalleşme platformu.">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="tr">
    <meta property="og:url" content="https://gazisocial.com/games">
    <meta property="og:image" content="{{ asset('logos/GS_LOGO_DEFAULT.png') }}" itemprop="image">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Sosyalleşmenin yeni adresi - Gazi Social">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Gazi Social - Oyun Merkezi">
    <meta name="twitter:image" content="{{ asset('logos/GS_LOGO_DEFAULT.png') }}">
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Oyun Merkezi - Gazi Social' }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon-16x16.png') }}">
</head>

<body x-data="{
    fullscreen: false,
}"
    class="min-h-svh flex flex-col w-full overflow-x-hidden bg-slate-100 font-inter antialiased">
    <div x-show="!fullscreen">
        <x-layout.navbar />
    </div>
    <main
        :class="{
            'h-svh': fullscreen,
            'mx-0 my-0 h-auto lg:my-14 lg:mx-[8%]': !fullscreen,
        }"
        class="mx-0 my-0 h-auto lg:my-14 lg:mx-[8%]">
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
