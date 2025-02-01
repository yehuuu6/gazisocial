<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @livewireStyles
    <title>{{ $title }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen w-full bg-white font-inter antialiased">
    {{ $slot }}
    <x-toaster-hub />
    @livewireScriptConfig
</body>

</html>
