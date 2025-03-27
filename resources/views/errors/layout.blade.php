<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title') - Gazi Social</title>
</head>

<body
    class="flex flex-col items-center justify-center min-h-svh w-full overflow-x-hidden bg-gradient-to-br from-cyan-100 to-blue-100 font-inter antialiased">
    <main class="mx-[6%] md:mx-[12%] flex flex-col items-center justify-center w-full">
        <h1 class="text-9xl text-center font-extrabold text-primary animate-bounce">
            @yield('code')
        </h1>
        <h2 class="text-2xl mt-1.5 font-semibold text-center text-gray-800 w-3/4">
            @yield('message')
        </h2>
        <p class="text-center text-xl font-medium text-gray-700 mt-5 w-3/4">
            @yield('extra')
        </p>
    </main>
    @livewireScriptConfig
</body>

</html>
