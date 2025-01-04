<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('canonical')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'Sosyalleşmenin yeni adresi - Gazi Social' }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script>
        if (navigator.userAgent.match(/samsung/i)) {
            alert("Tarayıcınız (Samsung Internet) bu siteyi doğru göstermeyebilir. " +
                "Lütfen koyu temayı kapatın (açıksa) veya farklı bir tarayıcı kullanın.\n\n" +
                "Firefox, Microsoft Edge, ya da Google Chrome önerebiliriz.");
        }
    </script>
    @stack('scripts')
</head>

<body class="min-h-screen w-full overflow-x-hidden bg-slate-100 font-inter antialiased">
    <livewire:layout.navbar />
    <livewire:layout.header />
    <main class="mx-[3%] mt-4 md:mx-[6%] md:mt-8 lg:mx-[12%]">
        {{ $slot }}
    </main>
    <x-layout.footer />
</body>

</html>
